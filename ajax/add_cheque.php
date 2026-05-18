<?php
ob_end_clean(); 
header('Content-Type: application/json');
error_reporting(0);
ini_set('display_errors', 1);
session_start();

include_once("../lib/config.php");
include_once("../lib/class/class.dbcon.php");
include_once("../lib/class/class.legal_cheque.php");
include_once("../lib/class/class.legal_case.php");
include_once("../lib/class/class.legal_activity_log.php");

$objLegalCase = new LegalCase();
$objCheque = new Cheque();
$objLogger = new LegalActivityLog();

if ($_POST) {
    $input_data = array();
    $uploadDir = '../uploads/all_cheque' . DIRECTORY_SEPARATOR;

    // CSRF token validation
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid CSRF token.']);
        exit;
    }

    // Create directory if it doesn't exist
    if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
        echo json_encode(['success' => false, 'status' => 'error', 'message' => 'Failed to create upload directory.']);
        exit;
    }

    // Hidden fields
    $postmodule  = isset($_POST['hid_module']) ? htmlspecialchars($_POST['hid_module']) : null;
    $postpage    = isset($_POST['hid_page']) ? htmlspecialchars($_POST['hid_page']) : null;
    $postID      = isset($_POST['hid_parentID']) ? htmlspecialchars($_POST['hid_parentID']) : null;

    $parentType = '';
    $parentID = null;

    switch ($postmodule) {
        case 'client':
            $parentType = 'C';
            $parentID = $postID;
            break;
        case 'case':
            $parentType = 'CA';
            if ($postID) {
                $case = $objLegalCase->get_case($postID);
                $parentID = isset($case[0]['client_id']) ? $case[0]['client_id'] : null;
            }
            break;
    }

    // Cheque fields
    $cheque_type   = isset($_POST['cheque_type']) ? htmlspecialchars($_POST['cheque_type']) : null;
    $cheque_date   = isset($_POST['cheque_date']) ? htmlspecialchars($_POST['cheque_date']) : null;
    // Strictly parse the amount and consider empty strings as null to fail validation
    $cheque_amount = (isset($_POST['cheque_amount']) && $_POST['cheque_amount'] !== '') ? floatval($_POST['cheque_amount']) : null;
    $cheque_number = isset($_POST['cheque_number']) ? htmlspecialchars($_POST['cheque_number']) : '';
    $cheque_bank   = isset($_POST['cheque_bank']) ? htmlspecialchars($_POST['cheque_bank']) : '';
    $cheque_notes  = isset($_POST['notes']) ? htmlspecialchars($_POST['notes']) : '';

    // ✅ Robust Validation (Fixes the "0" value issue)
    $isValid = true;
    if ($cheque_type == 1) {
        if (empty($cheque_date) || $cheque_amount === null || $cheque_amount <= 0 || strlen((string)$cheque_number) === 0 || empty($cheque_bank) || empty($parentID)) {
            $isValid = false;
        }
    } else {
        if (empty($cheque_date) || strlen((string)$cheque_number) === 0 || $cheque_amount === null || $cheque_amount <= 0 || empty($parentID)) {
            $isValid = false;
        }
    }

    if (!$isValid) {
        echo json_encode(['status' => 'error', 'message' => 'Validation Error: Please make sure to fill the Amount field (> 0) along with Date, Number, and Bank.', 'debug_post' => $_POST]);
        exit;
    }

    // ✅ File Upload Logic
    $uniqueFileName = '';
    if (isset($_FILES['cheque_name']) && $_FILES['cheque_name']['error'] === UPLOAD_ERR_OK) {
        $fileExtension = strtolower(pathinfo($_FILES['cheque_name']['name'], PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf'];

        if (in_array($fileExtension, $allowedExtensions)) {
            $uniqueFileName = time() . '_' . uniqid() . '.' . $fileExtension;
            $targetFilePath = $uploadDir . $uniqueFileName;
            move_uploaded_file($_FILES['cheque_name']['tmp_name'], $targetFilePath);
        }
    }

    // ✅ Prepare DB Data
    $input_data = [
        'add_type'           => $cheque_type,
        'upload_date'        => $cheque_date,
        'amount'             => $cheque_amount,
        'cheque_name'        => $uniqueFileName,
        'notes'              => $cheque_notes,
        'parent_id'          => $parentID,
        'type'               => $parentType,
        'cheque_number'      => $cheque_number,
        'cheque_bank'        => $cheque_bank,
        'cheque_bounced_date'=> null,
        'create_by'          => $_SESSION['LOGIN_LEGAL_ID'],
        'create_on'          => date('Y-m-d H:i:s')
    ];

    // ✅ Store in Table
    if ($objCheque->upload_cheque($input_data)) {
        $newID = $objCheque->mysqlInsertid();
        
        // Add Activity Log
        $logMsg = ($cheque_type == 1 ? "Added PDC" : "Added Invoice") . " for parent ID: $parentID. Amount: $cheque_amount";
        $objLogger->logActivity('INSERT', 'legal_cheque_upload', $_SESSION['LOGIN_LEGAL_ID'], $logMsg, $newID);

        echo json_encode([
            'success' => true,
            'status' => 'success',
            'message' => 'Data stored successfully!',
            'file_name' => $uniqueFileName
        ]);
    } else {
        echo json_encode(['success' => false, 'status' => 'error', 'message' => 'Failed to store data in database.']);
    }
}
?>
