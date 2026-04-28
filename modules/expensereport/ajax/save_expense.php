<?php
ob_start();
session_start();
error_reporting(0);

include_once("../../../lib/config.php");
include_once("../../../lib/class/class.dbcon.php");
include_once("../../../lib/class/class.legal_expense.php");

$objExpense = new Expense();


if ($_POST) {


    function clean_input($value)
    {
        return trim(htmlspecialchars($value, ENT_QUOTES, 'UTF-8'));
    }

    $marketing_id = isset($_POST['select_marketing']) ? clean_input($_POST['select_marketing']) : '';
    $client_id = isset($_POST['select_client']) ? clean_input($_POST['select_client']) : '';
    $active_legal_id = isset($_POST['select_active_legal']) ? clean_input($_POST['select_active_legal']) : '';
    $case_id = isset($_POST['select_active_legal_case']) ? clean_input($_POST['select_active_legal_case']) : '';
    $category_type = isset($_POST['category_type']) ? clean_input($_POST['category_type']) : '';
    $party_names_id = isset($_POST['party_names']) ? clean_input($_POST['party_names']) : '';
    $exp_date = isset($_POST['exp_date']) ? clean_input($_POST['exp_date']) : '';
    $fee_type = isset($_POST['fee_type']) ? clean_input($_POST['fee_type']) : '';
    // $amount = $_POST['amount'] ?? '';
    $amount = isset($_POST['amount']) ? (float) $_POST['amount'] : 0.00;
    $description = isset($_POST['description']) ? clean_input($_POST['description']) : '';
    $remark = isset($_POST['remark']) ? clean_input($_POST['remark']) : '';

    $category_map = [
        'third_party'   => 'TP',
        'debt_collector'=> 'DC',
        'legal_firm'    => 'LF',
        'legal_team'    => 'LT'
    ];
    
    $category_type_raw = $_POST['category_type'] ?? '';
    $category_type = $category_map[$category_type_raw] ?? '';


    $input_array = [];
    $input_array['marketing_id'] = $marketing_id;
    $input_array['client_id'] = $client_id;
    $input_array['active_legal_id'] = $active_legal_id;
    $input_array['case_id'] = $case_id;
    $input_array['category_type'] = $category_type;
    $input_array['firm_id'] = $party_names_id;
    $input_array['date'] = $exp_date;
    $input_array['fees_type'] = $fee_type;
    $input_array['amount'] = $amount;
    $input_array['description'] = $description;
    $input_array['remark'] = $remark;

    $input_array['created_by'] = $_SESSION['LOGIN_LEGAL_ID'];
    $input_array['created_on'] = date('Y-m-d H:i:s');

    // exit;


    $attachment_path = null; 
    if (isset($_FILES['attachment_file']) && $_FILES['attachment_file']['error'] === UPLOAD_ERR_OK) {

        $fileTmpPath = $_FILES['attachment_file']['tmp_name'];
        $fileName    = basename($_FILES['attachment_file']['name']);
        $fileSize    = $_FILES['attachment_file']['size'];
        $fileType    = mime_content_type($fileTmpPath); // safer than $_FILES['type']

        // Allowed file types
        $allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
        $maxSize      = 1 * 1024 * 1024; // 1MB

        if (!in_array($fileType, $allowedTypes)) {
            $response = ['success' => false, 'message' => 'Invalid file type. Only JPG, PNG, PDF allowed.'];
            echo json_encode($response);
            exit;
        }

        if ($fileSize > $maxSize) {
            $response = ['success' => false, 'message' => 'File size exceeds 1MB limit.'];
            echo json_encode($response);
            exit;
        }

        // Generate safe new filename
        $uploadDir = dirname(__DIR__, 3) . "/uploads/expenses/";

    
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $newFileName = uniqid("doc_", true) . "." . pathinfo($fileName, PATHINFO_EXTENSION);
        $destPath    = $uploadDir . $newFileName;

        if (move_uploaded_file($fileTmpPath, $destPath)) {
            $attachment_path = $newFileName;
            $input_array['document'] = $attachment_path; 
        } else {
            $response = ['success' => false, 'message' => 'Error moving uploaded file.'];
            echo json_encode($response);
            exit;
        }
    }

    $result =  $objExpense->save_expense($input_array);

   
    header('Content-Type: application/json');

    // Return the result as JSON
    echo json_encode(['success' => $result]);
    exit;
}
