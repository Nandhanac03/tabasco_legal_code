<?php

if (LEGAL_AUTH_VIEW == false) {
    header("Location: " . ROOT_DIR . "permission_denied.php");
    exit();
}


ob_start();
session_start();

$rootPath = dirname(dirname(__DIR__)); // Go 2 levels up to root (from modules/activelegal)

include_once($rootPath . "/lib/config.php");
include_once($rootPath . "/lib/class/class.dbcon.php");
include_once($rootPath . "/lib/class/class.legal_active_legals.php");
include_once($rootPath . "/lib/class/class.legal_case.php");
include_once($rootPath . "/lib/class/class.legal_client.php");
include_once($rootPath . "/lib/class/class.legal_case_mode.php");
include_once($rootPath . "/lib/class/class.legal_common_selection.php");

$objCommonSelection = new CommonSelection();
$objCaseMode = new Case_mode();
$objActiveLegal = new ActiveLegal();
$objLegalCase = new LegalCase();
$objClients = new Clients();

// Handle AJAX request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'change_status') {
    // Debug incoming request
    // echo '<pre>'; print_r($_POST); exit;

    $id = (int)$_POST['id'];
    $newStatus = $_POST['newStatus'];

    $success = $objActiveLegal->Manage_ActiveLegal(['legal_status' => $newStatus], $id);

    header('Content-Type: application/json');
    if ($success) {
        echo json_encode(['success' => true, 'message' => 'Status updated']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Update failed']);
    }
    exit;
}

$array_users = array();

$array_users = $objCommonSelection->get_all_users('yes', '21,1');
$array_legal_client_marketing    =   array();
$array_legal_client_marketing    =   $objCommonSelection->get_marketing_legal_client();

$array_legal_case    =   array();
$array_legal_case = $objLegalCase->get_legal_case();

$array_legal_clients = array();
$array_legal_clients = $objClients->Get_Client_Information(null, null, null, 'A');

$actve_sub_menu = 'dashboard';

$body   =   "list.tpl";
