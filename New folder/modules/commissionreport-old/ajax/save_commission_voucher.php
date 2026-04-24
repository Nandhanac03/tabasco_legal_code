<?php
ob_start();
session_start();

include_once "../../../lib/config.php";
include_once "../../../lib/class/class.dbcon.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

$db = new Dbcon();

try {

    // =========================
    // 1. GET DATA
    // =========================
    $voucher_no     = trim($_POST['voucher_no'] ?? '');
    $payment_date   = $_POST['payment_date'] ?? '';
    $payment_method = $_POST['payment_method'] ?? '';
    $amount_paid    = floatval($_POST['amount_paid'] ?? 0);
    $remarks        = $_POST['remarks'] ?? '';
    $user_id        = $_SESSION['LOGIN_LEGAL_ID'] ?? 0;
    $user_type      = $_SESSION['LOGIN_LEGAL_TYPE_NAME'];

    if (!$voucher_no || !$payment_date || !$payment_method || $amount_paid <= 0) {
        throw new Exception("Fill all required fields");
    }

    // =========================
    // 2. FILE UPLOAD
    // =========================
    if (!isset($_FILES['signed_doc']) || $_FILES['signed_doc']['error'] != 0) {
        throw new Exception("Upload signed document");
    }

    $allowed = ['pdf','jpg','jpeg','png'];
    $ext = strtolower(pathinfo($_FILES['signed_doc']['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed)) {
        throw new Exception("Invalid file type");
    }

    $upload_dir = "../../../uploads/expenses/";

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    if (!is_writable($upload_dir)) {
        throw new Exception("Upload folder not writable");
    }

    $file_name = "signed_" . time() . "_" . rand(1000,9999) . "." . $ext;

    if (!move_uploaded_file($_FILES['signed_doc']['tmp_name'], $upload_dir . $file_name)) {
        throw new Exception("File upload failed");
    }

    // =========================
    // 3. GET VOUCHER
    // =========================
    $voucher = $db->SQL_Fetch(
        "SELECT * FROM legal_commission_voucher WHERE voucher_no = ? LIMIT 1",
        [$voucher_no]
    );

    if (!$voucher) {
        throw new Exception("Voucher not found");
    }

    if ($voucher['status'] == 'Paid') {
        throw new Exception("Already paid");
    }

    // Amount check
    if (round($amount_paid,2) != round($voucher['total_amount'],2)) {
        throw new Exception("Amount mismatch. Expected amount is: " . number_format($voucher['total_amount'], 2));
    }

    $voucher_id = $voucher['id'];

    // =========================
    // 4. UPDATE VOUCHER
    // =========================
    $db->Query(
        "UPDATE legal_commission_voucher SET
            status='Paid',
            payment_date=?,
            payment_method=?,
            amount_paid=?,
            remarks=?,
            signed_doc=?,
            printed_at=NOW()
         WHERE id=?",
        [$payment_date, $payment_method, $amount_paid, $remarks, $file_name, $voucher_id]
    );

    // =========================
    // 5. UPDATE COMMISSION
    // =========================
    $db->Query(
        "UPDATE legal_collection_commission 
         SET payment_status='Paid' 
         WHERE voucher_id=?",
        [$voucher_id]
    );

    // =========================
    // 5.5 FETCH LINKED IDS FOR EXPENSE
    // =========================
    $linked_data = $db->SQL_Fetch(
        "SELECT active_legal_id, case_id, party_id AS firm_id, collection_id
         FROM legal_collection_commission
         WHERE voucher_id = ? LIMIT 1",
        [$voucher_id]
    );

    $active_legal_id = $linked_data['active_legal_id'] ?? null;
    $case_id         = $linked_data['case_id'] ?? null;
    $firm_id         = $linked_data['firm_id'] ?? null;
    $collection_id   = $linked_data['collection_id'] ?? null;

    $marketing_id = null;
    $client_id    = null;

    if ($collection_id) {
        $coll = $db->SQL_Fetch(
            "SELECT marketing_id, client_id FROM legal_collections WHERE id = ?",
            [$collection_id]
        );
        if ($coll) {
            $marketing_id = $coll['marketing_id'] ?? null;
            $client_id    = $coll['client_id'] ?? null;
        }
    }

    // =========================
    // 6. INSERT EXPENSE
    // =========================
    $db->Query(
        "INSERT INTO legal_expense
        (marketing_id, client_id, active_legal_id, case_id, category_type, firm_id, date, fees_type, amount, description, remark, document, created_by, created_on, status)
        VALUES (?, ?, ?, ?, 'Commission Expense', ?, ?, 'Commission', ?, ?, ?, ?, ?, NOW(), 'A')",
        [
            $marketing_id,
            $client_id,
            $active_legal_id,
            $case_id,
            $firm_id,
            $payment_date,
            $amount_paid,
            "Commission Payment - Voucher: ".$voucher_no,
            $remarks,
            $file_name,
            $user_id
        ]
    );

    // =========================
    // 7. ACTIVITY LOG
    // =========================
    $db->Query(
        "INSERT INTO legal_activity_log
        (log_datetime, log_date, log_user, log_utype, log_menu, log_action, log_message, log_refr_id, log_url)
        VALUES (NOW(), CURDATE(), ?, ?, 'Commission', 'Payment', ?, ?, ?)",
        [
            $user_id,
            $user_type,
            "Voucher Paid: ".$voucher_no." | Amount: ".$amount_paid,
            $voucher_id,
            $_SERVER['REQUEST_URI'] ?? ''
        ]
    );

    // =========================
    // 8. GET COMMISSION COUNT FOR MESSAGE
    // =========================
    $comm_count_query = $db->SELECT_MultiFetch(
        "SELECT COUNT(*) as total_comm FROM legal_collection_commission WHERE voucher_id=?",
        [$voucher_id]
    );
    $total_commissions = $comm_count_query[0]['total_comm'] ?? 0;

    // =========================
    // SUCCESS
    // =========================
    echo json_encode([
        "success" => true,
        "message" => "Payment successfully processed for Voucher {$voucher_no}. A total of {$total_commissions} commission records have been marked as paid."
    ]);

} catch (Exception $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
