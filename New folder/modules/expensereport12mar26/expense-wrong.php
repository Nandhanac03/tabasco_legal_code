<?php
ob_start();
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once("../../../lib/config.php");
include_once("../../../lib/class/class.dbcon.php");
include_once("../../../lib/class/class.legal_expense.php");

$objExpense = new Expense();

header('Content-Type: application/json');

if ($_POST) {

    function clean_input($value)
    {
        return trim(htmlspecialchars($value, ENT_QUOTES, 'UTF-8'));
    }

    $marketing_id = clean_input($_POST['select_marketing'] ?? '');
    $client_id = clean_input($_POST['select_client'] ?? '');
    $active_legal_id = clean_input($_POST['select_active_legal'] ?? '');
    $case_id = clean_input($_POST['select_active_legal_case'] ?? '');
    $exp_date = clean_input($_POST['exp_date'] ?? '');
    $fee_type = clean_input($_POST['fee_type'] ?? '');
    $amount = clean_input($_POST['amount'] ?? '');
    $description = clean_input($_POST['description'] ?? '');
    $remark = clean_input($_POST['remark'] ?? '');
    $party_names_id = clean_input($_POST['party_names'] ?? '');

    $category_map = [
        'third_party'   => 'TP',
        'debt_collector'=> 'DC',
        'legal_firm'    => 'LF',
        'legal_team'    => 'LT'
    ];

    $category_type_raw = $_POST['category_type'] ?? '';
    $category_type = $category_map[$category_type_raw] ?? '';

    $input_array = [
        'marketing_id' => $marketing_id,
        'client_id' => $client_id,
        'active_legal_id' => $active_legal_id,
        'case_id' => $case_id,
        'category_type' => $category_type,
        'firm_id' => $party_names_id,
        'date' => $exp_date,
        'fees_type' => $fee_type,
        'amount' => $amount,
        'description' => $description,
        'remark' => $remark,
        'created_by' => $_SESSION['LOGIN_LEGAL_ID'],
        'created_on' => date('Y-m-d H:i:s')
    ];

    // FILE UPLOAD
    if (isset($_FILES['attachment_file']) && $_FILES['attachment_file']['error'] === UPLOAD_ERR_OK) {

        $fileTmpPath = $_FILES['attachment_file']['tmp_name'];
        $fileName = basename($_FILES['attachment_file']['name']);
        $fileSize = $_FILES['attachment_file']['size'];
        $fileType = mime_content_type($fileTmpPath);

        $allowedTypes = ['image/jpeg','image/png','application/pdf'];
        $maxSize = 1 * 1024 * 1024;

        if (!in_array($fileType, $allowedTypes)) {
            echo json_encode([
                'success'=>false,
                'message'=>'Invalid file type'
            ]);
            exit;
        }

        if ($fileSize > $maxSize) {
            echo json_encode([
                'success'=>false,
                'message'=>'File exceeds 1MB'
            ]);
            exit;
        }

        $uploadDir = dirname(__DIR__,3)."/uploads/expenses/";

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir,0755,true);
        }

        $newFileName = uniqid().".".pathinfo($fileName,PATHINFO_EXTENSION);
        $destPath = $uploadDir.$newFileName;

        if (move_uploaded_file($fileTmpPath,$destPath)) {
            $input_array['document'] = $newFileName;
        }
    }

    $result = $objExpense->save_expense($input_array);

    if ($result) {

        echo json_encode([
            'success'=>true,
            'message'=>'Expense saved successfully'
        ]);

    } else {

        echo json_encode([
            'success'=>false,
            'message'=>'Database insert failed'
        ]);
    }

} else {

    echo json_encode([
        'success'=>false,
        'message'=>'Invalid request'
    ]);
}

exit;
