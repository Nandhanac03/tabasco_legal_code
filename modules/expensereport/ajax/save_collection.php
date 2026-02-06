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

    function clean_input($value)
    {
        return trim(htmlspecialchars($value, ENT_QUOTES, 'UTF-8'));
    }


    $marketing_id = isset($_POST['coll_select_marketing']) ? clean_input($_POST['coll_select_marketing']) : '';
    $client_id = isset($_POST['coll_select_client']) ? clean_input($_POST['coll_select_client']) : '';
    $active_legal_id = isset($_POST['coll_select_active_legal']) ? clean_input($_POST['coll_select_active_legal']) : '';
    $case_id = isset($_POST['coll_select_active_legal_case']) ? clean_input($_POST['coll_select_active_legal_case']) : '';
    // $category_type = isset($_POST['coll_category_type']) ? clean_input($_POST['coll_category_type']) : '';
    $party_names_id = isset($_POST['coll_party_names']) ? clean_input($_POST['coll_party_names']) : '';
    $exp_date = isset($_POST['coll_exp_date']) ? clean_input($_POST['coll_exp_date']) : '';
    // $fee_type = isset($_POST['coll_fee_type']) ? clean_input($_POST['coll_fee_type']) : '';
    $amount = isset($_POST['coll_amount']) ? clean_input($_POST['coll_amount']) : '';
    $description = isset($_POST['coll_description']) ? clean_input($_POST['coll_description']) : '';
    $remark = isset($_POST['remark']) ? clean_input($_POST['remark']) : '';

    $category_map = [
        'third_party'   => 'TP',
        'debt_collector' => 'DC',
        'legal_firm'    => 'LF',
        'legal_team'    => 'LT'
    ];

    $category_type_raw = $_POST['coll_category_type'] ?? '';
    $category_type = $category_map[$category_type_raw] ?? '';

    $data = [];
    switch ($category_type) {
        case 'TP':
            include_once("../../../lib/class/class.legal_third_party.php");
            $objThirdParty = new thirdParty();
            $data = $objThirdParty->get_legal_third_Information($party_names_id, '', '', 'A');
            break;
        case 'DC':
            include_once("../../../lib/class/class.legal_debt_collector.php");
            $objDebtCollector = new DebtCollector();
            $data = $objDebtCollector->getDebtCollectorInfo(['id' => $party_names_id]);
            break;
        case 'LF':
            include_once("../../../lib/class/class.legal_firm.php");
            $objLegalFirm = new LegalFirm();
            $data = $objLegalFirm->getLegalFirmInformation(['id' => $party_names_id]);
            break;
        case 'LT':
            // DATA SHOULD BE ADDED IN FUTURE. DONT REMEMBER
            include_once("../../../lib/class/class.legal_users.php");
            $ObjUsersClass = new UsersClass();
            // DATA SHOULD BE ADDED IN FUTURE. DONT REMEMBER
            $array_data = $ObjUsersClass->get_all_Users($party_names_id, '', 23);
            // Convert to desired format
            $data = array_map(function ($item) {
                return [
                    'id' => (string) $item['user_Id'],   // Convert to string if needed
                    'name' => $item['user_name'],
                    'code' => '',
                ];
            }, $array_data);
            break;
        default:
            break;
    }

    if (!empty($data)) {
        $client = $data[0]['name'];
    } else {
        $client = '';
    }


    $commission_details = $objActiveLegal->get_commission('', $active_legal_id, $category_type, $party_names_id);
    $commission_percentage = $commission_details[0]['commission'];
    $commission_id = $commission_details[0]['id'];
    $com_amount  = 0;
    if ($commission_percentage) {
        $com_amount = $amount / 100 * $commission_percentage;
    }
    if ($com_amount > 0) {
        $c_comment = "A commission of $com_amount is payable to $client";
    }
    if ($commission_details) {
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
        if (isset($_FILES['coll_attachment_file']) && $_FILES['coll_attachment_file']['error'] === UPLOAD_ERR_OK) {

            $fileTmpPath = $_FILES['coll_attachment_file']['tmp_name'];
            $fileName    = basename($_FILES['coll_attachment_file']['name']);
            $fileSize    = $_FILES['coll_attachment_file']['size'];
            $fileType    = mime_content_type($fileTmpPath);

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

            $uploadDir = dirname(__DIR__, 3) . "/uploads/collection/";


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

        $result =  $objCollection->save_collection($input_array);
    } else {
        $c_comment = 'Please set commission Percentage from Active legal';
    }

    $collection =  $objCollection->get_last_collection();

    //echo '<pre>';print_r($collection);exit;
    if ($commission_details) {
        $commision_array = array();
        $commision_array['active_legal_id'] = $active_legal_id;
        $commision_array['case_id'] = $case_id;
        $commision_array['collection_id'] = $collection['id'];
        $commision_array['parent_type'] = $category_type;
        $commision_array['party_id'] = $party_names_id;
        $commision_array['amount'] = $amount;
        $commision_array['date'] = $exp_date;
        $commision_array['created_by'] = $_SESSION['LOGIN_LEGAL_ID'];
        $commision_array['created_on'] = date('Y-m-d H:i:s');
        $commision_array['commission_percentage'] = $commission_percentage;
        $commision_array['active_legal_commisionId'] = $commission_id;


        if ($commision_array) {
            $objCollectionCommission->save_collection_commission($commision_array);
        }
    } else {
        $c_comment = 'Please set commission Percentage from Active legal';
    }


    header('Content-Type: application/json');

    echo json_encode(['success' => $result, 'c_comment' => $c_comment]);
    exit;
}
