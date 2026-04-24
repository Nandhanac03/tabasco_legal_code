<?php
include_once("lib/auth.php");
if (LEGAL_AUTH_VIEW==false){
    header("Location: ".ROOT_DIR."permission_denied.php");
    exit();
}
ob_start();
session_start();
# including files here
include_once("lib/config.php");
include_once("lib/class/class.dbcon.php");
include_once("lib/class/class.legal_case.php");
include_once("lib/class/class.legal_client.php");
include_once("lib/class/class.legal_common_selection.php");

$objCommonSelection = new CommonSelection();
$objLegalCase = new LegalCase();
$objClients = new Clients();

$array_users = array();

$array_users = $objCommonSelection->get_all_users('yes', '21,1');

$array_legal_client_marketing    =   array();
$array_legal_client_marketing    =   $objCommonSelection->get_marketing_legal_client();

$array_legal_case    =   array();
$array_legal_case = $objLegalCase->get_legal_case();

$array_legal_clients = array();
$array_legal_clients = $objClients->Get_Client_Information(null, null, null, 'A');



$body   =   "list.tpl";