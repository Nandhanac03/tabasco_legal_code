<?php
header('Content-Type: application/json');
error_reporting(0);
ini_set('display_errors', 1);
session_start();
// Include necessary files
include_once("../lib/config.php");
include_once("../lib/class/class.dbcon.php");
include_once("../lib/class/class.legal_case.php");
include_once("../lib/class/class.legal_document.php");
$objprocessDocument = new processDocument();
$objLegalCase =   new LegalCase();
$array_list =   array();


$parent_id      = $_REQUEST['parent_id'] ?? null;
$list_module    = $_REQUEST['list_module'] ?? null;
$list_page      = $_REQUEST['list_page'] ?? null;
$alphabet       = $_REQUEST['alphabet'] ?? null;


switch ($list_module) {
    case 'legalfirm':
        $parent_type = 'LF';
        break;
    case 'client':
        $parent_type = 'C';
        break;
    case 'thirdparty':
        $parent_type = 'TP';
        break;
    case 'activelegal':
        $parent_type = 'AL';
        break;
    default:
        $parent_type = '';
        break;
}

if ($list_module === 'case') {
    $legal_case = $objLegalCase->get_case_info($parent_id);
    $client_id = $legal_case[0]['client_id'];
}


if (!$parent_id && !$alphabet) {

    echo json_encode(['success' => false, 'status' => 'error', 'message' => ' Error . No Parameter found.']);
    exit;
}

if ($alphabet == 'list') {
    $array_list = $objprocessDocument->get_document('', $parent_id, $parent_type);
    $array_list = is_array($array_list) ? $array_list : [];
    
    if ($list_module === 'case' && isset($client_id)) {
        $client_array = $objprocessDocument->get_document('', $client_id, 'C');
        $client_array = is_array($client_array) ? $client_array : [];
    
        if (!empty($client_array)) {
            $array_list = array_merge($array_list, $client_array);
        }
    }
    


    echo json_encode([
        'success' => true,
        'status' => 'success',
        'ID' => $parent_id,
        'data' => $array_list
    ]);
    exit;
} else if ($alphabet == 'delete') {
    $id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
    if ($id <= 0) {
        echo json_encode(['success' => false, 'status' => 'error', 'message' => 'Invalid  Parameter.']);
        exit;
    }

    $array_list =   $objprocessDocument->get_document($id)[0];
    if (isset($array_list)) {
        $input_data = [
            'id'         => $id,
            'status'     => 'D',
            'update_by'  => $_SESSION['LOGIN_LEGAL_ID'],
            'update_on'  => date('Y-m-d H:i:s')
        ];

        $filePath = isset($array_list['name']) ? $array_list['name'] : '';
        $uploadDir = '../uploads/all_document/' . $filePath;
        if ($objprocessDocument->Delete_document($id, $input_data)) {
            if (!empty($filePath) && file_exists($uploadDir)) {
                unlink($uploadDir); // Safely remove the uploaded file
            }
            echo json_encode(['success' => true, 'status' => 'success', 'message' => 'Document deleted successfully.']);
        } else {
            echo json_encode(['success' => false, 'status' => 'error', 'message' => 'Failed to delete document.']);
        }
    } else {
        echo json_encode(['success' => false, 'status' => 'error', 'message' => 'Document not found.']);
    }
}
