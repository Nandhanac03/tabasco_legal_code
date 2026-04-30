<?php

if (LEGAL_AUTH_VIEW==false){
    header("Location: ".ROOT_DIR."permission_denied.php");
    exit();
}
include_once("lib/config.php");
include_once("lib/class/class.dbcon.php");
include_once("lib/class/class.legal_common_selection.php");
include_once("lib/class/class.legal_case.php");
$objLegalCase = new LegalCase();


include_once("lib/class/class.legal_client.php");
$objClients = new Clients();

$objCommonSelection = new CommonSelection();

$array_users = array();

$array_users = $objCommonSelection->get_all_users('yes', '21,1');

$array_legal_client_marketing    =   array();
$array_legal_client_marketing    =   $objCommonSelection->get_marketing_legal_client();


$array_legal_case    =   array();
$array_legal_case = $objLegalCase->get_legal_case();

$array_legal_clients = array();
$array_legal_clients = $objClients->Get_Client_Information(null, null, null, 'A');

$actve_sub_menu =   'bad_debts';
$body           =   "bad_debts.tpl";
?>