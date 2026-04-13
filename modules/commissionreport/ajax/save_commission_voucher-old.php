<?php
ob_start();
session_start();
include_once "../../../lib/config.php";
include_once "../../../lib/class/class.dbcon.php";
ob_clean();
header('Content-Type: application/json');

$db = new Dbcon();

// Get POST data
$voucher_no          = trim($_POST['voucher_no'] ?? '');
$payment_date        = $_POST['payment_date'] ?? null;
$payment_method      = $_POST['payment_method'] ?? null;
$amount_paid         = floatval($_POST['amount_paid'] ?? 0);
$signature_confirmed = $_POST['signature_confirmed'] ?? 0;
$remarks             = $_POST['remarks'] ?? '';

// Validate required fields
if (!$voucher_no || !$payment_date || !$payment_method || !$amount_paid || !$signature_confirmed) {
    ob_clean();
    echo json_encode(['success' => false, 'message' => 'All required fields must be filled']);
    exit;
}

// Validate signed document
if (empty($_FILES['signed_doc']['name'])) {
    ob_clean();
    echo json_encode(['success' => false, 'message' => 'Signed document is required']);
    exit;
}

// Validate file type
$allowed_ext = ['pdf', 'jpg', 'jpeg', 'png'];
$ext = strtolower(pathinfo($_FILES['signed_doc']['name'], PATHINFO_EXTENSION));

if (!in_array($ext, $allowed_ext)) {
    ob_clean();
    echo json_encode(['success' => false, 'message' => 'Invalid file type. Only PDF, JPG, PNG allowed']);
    exit;
}

// Step 1 - Get voucher from DB
$voucher = $db->SQL_Fetch(
    "SELECT id, total_amount, status 
     FROM legal_commission_voucher
     WHERE voucher_no = ? LIMIT 1",
    [$voucher_no]
);

if (!$voucher || empty($voucher['id'])) {
    ob_clean();
    echo json_encode(['success' => false, 'message' => 'Voucher not found: ' . $voucher_no]);
    exit;
}

// Check not already paid
if ($voucher['status'] === 'Paid') {
    ob_clean();
    echo json_encode(['success' => false, 'message' => 'This voucher has already been paid']);
    exit;
}

// Check amount matches
$voucher_amount = floatval($voucher['total_amount']);
if ($amount_paid != $voucher_amount) {
    ob_clean();
    echo json_encode([
        'success' => false,
        'message' => 'Amount paid (' . number_format($amount_paid,2) .
                     ') does not match voucher total (' . number_format($voucher_amount,2) . ')'
    ]);
    exit;
}

$voucher_id = $voucher['id'];

// Step 2 - Get commissions linked to voucher
$commissions = $db->SELECT_MultiFetch(
    "SELECT id, payment_status, active_legal_id, case_id, party_id, collection_id
     FROM legal_collection_commission
     WHERE voucher_id = ?",
    [$voucher_id]
);

if (empty($commissions)) {
    ob_clean();
    echo json_encode(['success' => false, 'message' => 'No commissions linked to this voucher']);
    exit;
}

// Check already paid commissions
foreach ($commissions as $c) {
    if ($c['payment_status'] === 'Paid') {
        ob_clean();
        echo json_encode(['success' => false, 'message' => 'Some commissions are already marked as Paid']);
        exit;
    }
}

// Get IDs from first commission row
$active_legal_id = $commissions[0]['active_legal_id'] ?? 0;
$case_id         = $commissions[0]['case_id'] ?? null;
$firm_id         = $commissions[0]['party_id'] ?? null;
$collection_id   = $commissions[0]['collection_id'] ?? null;


// Step 3 - Get marketing_id and client_id from legal_collections
$marketing_id = 0;
$client_id    = 0;

if ($collection_id) {
    $collection = $db->SQL_Fetch(
        "SELECT marketing_id, client_id
         FROM legal_collections
         WHERE id = ?",
        [$collection_id]
    );

    if ($collection) {
        $marketing_id = $collection['marketing_id'] ?? 0;
        $client_id    = $collection['client_id'] ?? 0;
    }
}


// Step 4 - Upload signed document
$upload_dir = '../../../uploads/expenses/';
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

$signed_doc = 'signed_' . time() . '.' . $ext;

if (!move_uploaded_file($_FILES['signed_doc']['tmp_name'], $upload_dir . $signed_doc)) {
    ob_clean();
    echo json_encode(['success' => false, 'message' => 'Failed to upload signed document']);
    exit;
}


// Step 5 - Update voucher to Paid
$db->Query(
    "UPDATE legal_commission_voucher
     SET status         = 'Paid',
         payment_date   = ?,
         payment_method = ?,
         amount_paid    = ?,
         remarks        = ?,
         signed_doc     = ?,
         printed_at     = NOW()
     WHERE id = ?",
    [$payment_date, $payment_method, $amount_paid, $remarks, $signed_doc, $voucher_id]
);


// Step 6 - Update commissions to Paid
$db->Query(
    "UPDATE legal_collection_commission
     SET payment_status = 'Paid'
     WHERE voucher_id = ?",
    [$voucher_id]
);


// Step 7 - Insert expense record
$db->Query(
    "INSERT INTO legal_expense
    (active_legal_id, case_id, firm_id, marketing_id, client_id, category_type, date, fees_type, amount, description, remark, document, created_by, created_on, status)
    VALUES (?, ?, ?, ?, ?, 'Commission Expense', ?, 'Commission', ?, ?, ?, ?, ?, NOW(), 'A')",
    [
        $active_legal_id,
        $case_id,
        $firm_id,
        $marketing_id,
        $client_id,
        $payment_date,
        $amount_paid,
        'Commission Expense - Voucher No: ' . $voucher_no,
        $remarks,
        $signed_doc,
        $_SESSION['LOGIN_LEGAL_ID'] ?? 0
    ]
);


// Step 8 - Insert activity log
// Step 8 - Insert activity log
$log_user = $_SESSION['LOGIN_LEGAL_ID'] ?? 0;

// Get user type from session
$raw_utype = $_SESSION['LOGIN_LEGAL_TYPE'] ?? 'Legal';

// Map to allowed values for DB column
$utype_map = [
    'Legal'      => 'Legal',
    'Admin'      => 'Admin',
    'User'       => 'User',
    'Staff'      => 'Staff',
    'Manager'    => 'Manager',
    'SuperAdmin' => 'Admin'
];

// Use mapped value or fallback
$log_utype = $utype_map[$raw_utype] ?? 'User';

// Build log message
$log_message = 'Commission Voucher Payment - Voucher No: ' . $voucher_no .
               ' | Amount: ' . number_format($amount_paid, 2) .
               ' | Method: ' . $payment_method .
               ' | Commissions: ' . count($commissions);

// Insert activity log
$db->Query(
    "INSERT INTO legal_activity_log
    (log_datetime, log_date, log_user, log_utype, log_url, log_menu, log_action, log_message, log_refr_id, log_parent_id, log_parent_type)
    VALUES (NOW(), CURDATE(), ?, 'Legal', '', 'Commission', 'Payment', ?, ?, ?, 'Commission')",
    [
        $log_user,        // ? 1 - log_user
        $log_message,     // ? 2 - log_message
        $voucher_id,      // ? 3 - log_refr_id
        $active_legal_id  // ? 4 - log_parent_id
    ]
);

// Success response
ob_clean();
echo json_encode([
    'success' => true,
    'message' => 'Payment saved successfully. ' . count($commissions) . ' commission(s) marked as Paid.'
]);
exit;
?>