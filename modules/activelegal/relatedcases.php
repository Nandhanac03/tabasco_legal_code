<?php
$edit_id = trim($_GET['param1']);
$action  = trim($_GET['action']);

if (!$edit_id) {
    header("location: " . ROOT_DIR . "permission_denied.php");
    exit;
}

include_once("lib/class/class.legal_category.php");
include_once("lib/class/class.legal_court.php");
include_once("lib/class/class.legal_users.php");
include_once("lib/class/class.legal_case_mode.php");
include_once("lib/class/class.legal_case.php");

include_once("lib/class/class.legal_client.php");
$objClients = new Clients();

$objCategory      = new Category();
$objCourt         = new Court();
$objUsers         = new UsersClass();
$objLegalCaseMode = new Case_mode();
$objLegalCase = new LegalCase();

$categories       = $objCategory->get_category();
$courts           = $objCourt->get_court();
$case_modes       = $objLegalCaseMode->get_case_mode();


$array_legal_case    =   array();
$array_legal_case = $objLegalCase->get_legal_case();

$list1            = $objUsers->get_all_Users(null, '', 23) ?: [];
$list2            = $objUsers->get_all_Users(null, '', 24) ?: [];
$lawyerusersList  = array_merge($list1, $list2);


$array_legal_clients = $objClients->Get_Client_Information(null, null, null, 'A');


$actve_sub_menu = 'dashboard';
$body = "relatedcases.tpl";
?>
