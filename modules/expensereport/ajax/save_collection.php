<?php
ob_start();
session_start();
error_reporting(0);

include_once("../../../lib/config.php");
include_once("../../../lib/class/class.dbcon.php");
include_once("../../../lib/class/class.legal_collection.php");
include_once("../../../lib/class/class.legal_active_legals.php");
include_once("../../../lib/class/class.legal_collection_commission.php");

$objActiveLegal = new ActiveLegal();
$objCollection = new Collection();
$objCollectionCommission = new LegalCollectionCommission();

if ($_POST) {

    function clean_input($v){
        return trim(htmlspecialchars($v, ENT_QUOTES, 'UTF-8'));
    }

    // INPUTS
    $marketing_id      = clean_input($_POST['coll_select_marketing'] ?? '');
    $client_id         = clean_input($_POST['coll_select_client'] ?? '');
    $active_legal_id   = clean_input($_POST['coll_select_active_legal'] ?? '');
    $case_id           = clean_input($_POST['coll_select_active_legal_case'] ?? '');
    $party_names_id    = clean_input($_POST['coll_party_names'] ?? '');
    $exp_date          = clean_input($_POST['coll_exp_date'] ?? '');
    $fee_type          = clean_input($_POST['coll_fee_type'] ?? '');
    $amount_raw        = $_POST['amount'] ?? '';
    $zero_commission   = $_POST['zero_commission'] ?? '0';
    $description       = clean_input($_POST['coll_description'] ?? '');
    $remark            = clean_input($_POST['remark'] ?? '');
    $category_raw      = $_POST['coll_category_type'] ?? '';

    $category_map = [
        'third_party'=>'TP',
        'debt_collector'=>'DC',
        'legal_firm'=>'LF',
        'legal_team'=>'LT'
    ];

    // VALIDATION
    $errors = [];

    if (!$active_legal_id) $errors[] = "Active Legal ID missing";
    if (!$category_raw || !isset($category_map[$category_raw])) $errors[] = "Invalid category";
    if (!$party_names_id) $errors[] = "Firm/Party required";
    if (!$exp_date) $errors[] = "Date required";

    if (!preg_match('/^\d+(\.\d{1,2})?$/', $amount_raw)) {
        $errors[] = "Invalid amount";
    }

    // ✅ FORCE CHECKBOX
    if ($zero_commission != '1') {
        $errors[] = "Please select 0% Commission to continue";
    }

    if (!empty($errors)) {
        ob_clean();
        echo json_encode([
            'success' => false,
            'message' => implode(" ", $errors)
        ]);
        exit;
    }

    $amount = (float)$amount_raw;
    $category = $category_map[$category_raw];

    // SAVE COLLECTION (NO CONDITION NOW)
    $data = [
        'marketing_id'=>$marketing_id,
        'client_id'=>$client_id,
        'active_legal_id'=>$active_legal_id,
        'case_id'=>$case_id,
        'category_type'=>$category,
        'firm_id'=>$party_names_id,
        'date'=>$exp_date,
        'fees_type'=>$fee_type,
        'amount'=>$amount,
        'zero_commission'=>1, // always 1
        'description'=>$description,
        'remark'=>$remark,
        'created_by'=>$_SESSION['LOGIN_LEGAL_ID'],
        'created_on'=>date('Y-m-d H:i:s')
    ];

    // FILE UPLOAD
    if (!empty($_FILES['coll_attachment_file']['name'])) {

        $tmp  = $_FILES['coll_attachment_file']['tmp_name'];
        $size = $_FILES['coll_attachment_file']['size'];
        $type = mime_content_type($tmp);

        if (!in_array($type,['image/jpeg','image/png','application/pdf'])) {
            echo json_encode(['success'=>false,'message'=>'Invalid file']);
            exit;
        }

        if ($size > 1024*1024) {
            echo json_encode(['success'=>false,'message'=>'File too large']);
            exit;
        }

        $dir = dirname(__DIR__,3)."/uploads/collection/";
        if (!is_dir($dir)) mkdir($dir,0755,true);

        $name = uniqid("doc_",true).".".pathinfo($_FILES['coll_attachment_file']['name'], PATHINFO_EXTENSION);
        move_uploaded_file($tmp,$dir.$name);

        $data['document'] = $name;
    }

    $result = $objCollection->save_collection($data);

    // SAVE COMMISSION
    if ($result) {

        $collection = $objCollection->get_last_collection();

        $objCollectionCommission->save_collection_commission([
            'active_legal_id'=>$active_legal_id,
            'case_id'=>$case_id,
            'collection_id'=>$collection['id'],
            'parent_type'=>$category,
            'party_id'=>$party_names_id,
            'amount'=>$amount,
            'zero_commission'=>1,
            'date'=>$exp_date,
            'created_by'=>$_SESSION['LOGIN_LEGAL_ID'],
            'created_on'=>date('Y-m-d H:i:s'),
            'commission_percentage'=>0,
            'active_legal_commisionId'=>0
        ]);
    }

    ob_clean();
    echo json_encode([
        'success'=>$result,
        'c_comment'=>"Saved with Zero Commission"
    ]);
    exit;
}
?>
