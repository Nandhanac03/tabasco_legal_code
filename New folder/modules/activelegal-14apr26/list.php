<?php

ob_start();
session_start();


include_once("lib/config.php");
include_once("lib/class/class.dbcon.php");
include_once("lib/class/class.legal_active_legals.php");
include_once("lib/class/class.legal_case.php");
include_once("lib/class/class.legal_case_mode.php");

include_once("lib/class/class.legal_common_selection.php");

$objCommonSelection = new CommonSelection();

$objCaseMode = new Case_mode();
$objActiveLegal = new ActiveLegal();
$objLegalCase = new LegalCase();



if (LEGAL_AUTH_VIEW == false) {
    header("Location: " . ROOT_DIR . "permission_denied.php");
    exit();
}

// Handle AJAX request
// if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'change_status') {
//     // Debug incoming request


//     $id = (int)$_POST['id'];

//     $input_data = [];
//     $input_data['legal_status'] = $_POST['newStatus'];
//     $input_data['legal_status_reason'] = $_POST['legalreson'];

//     $success = $objActiveLegal->Manage_ActiveLegal($input_data, $id);

//     header('Content-Type: application/json');
//     if ($success) {
//         echo json_encode(['success' => true, 'message' => 'Status updated']);
//     } else {
//         echo json_encode(['success' => false, 'message' => 'Update failed']);
//     }
//     exit;
// }

$array_users = array();

$array_users = $objCommonSelection->get_all_users('yes', '21,1');

$array_legal_client_marketing    =   array();
$array_legal_client_marketing    =   $objCommonSelection->get_marketing_legal_client();

$actve_sub_menu = 'dashboard';

$body   =   "list.tpl";
