<?php
ob_start();
session_start();
error_reporting(0);

include_once("../../../lib/config.php");
include_once("../../../lib/class/class.dbcon.php");
include_once("../../../lib/class/class.legal_cheque.php");

$objCheque = new Cheque();

if ($_POST) {

    $cheque_id = isset($_POST['cheque_id']) ? $_POST['cheque_id'] : null;
    $parent_type = 'CA';

    // CSRF token validation
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        echo json_encode(['success' => false, 'message' => 'Invalid CSRF token.']);
        exit;
    }

    $postID = isset($_POST['hid_parentID']) ? htmlspecialchars($_POST['hid_parentID']) : null;
    $post_module = isset($_POST['hid_module']) ? htmlspecialchars($_POST['hid_module']) : null;
    $post_page = isset($_POST['hid_page']) ? htmlspecialchars($_POST['hid_page']) : null;


    if (!$cheque_id || !$postID || !$post_module || !$post_page) {
        $response['message'] = VALIDATION_MSG;
        $response['success'] = false;
        echo json_encode($response);
        exit;
    }

    $cheque_available = $objCheque->get_cheque($cheque_id, $parentID, $parent_type);

    if (!$cheque_available) {
        $response['message'] = 'No cheque found !';
        $response['success'] = false;
        echo json_encode($response);
        exit;
    }
    // $cheque_name = $cheque_available[0]['cheque_name'];
    // $uploadDir = realpath(__DIR__ . '/../../../');
    // $uploadDir .= '/uploads/all_cheque/';
    // $cheque_file = $uploadDir . $cheque_name;

    $input_data = [];
    $input_data['status'] = 'D';
    if ($objCheque->Delete_Cheque($cheque_id, $input_data)) {
        $response['message'] = 'Cheque has been deleted';
        $response['success'] = true;
    } else {
        $response['message'] = 'Failed to delete Cheque.';
        $response['success'] = false;
    }
    echo json_encode($response);
    exit;
} else {
    echo json_encode(['success' => false, 'msg' => 'Request Denied']);
    exit;
}
