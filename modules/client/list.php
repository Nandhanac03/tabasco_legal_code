<?php
if (LEGAL_AUTH_VIEW==false){
    header("Location: ".ROOT_DIR."permission_denied.php");
    exit();
}
include_once("lib/class/class.legal_common_selection.php");
$objCommonSelection =   new CommonSelection();

include_once("lib/class/class.legal_client.php");
$objClients = new Clients();

include_once("lib/class/class.legal_case.php");
$objLegalCase = new LegalCase();



$array_marketing    =   array();
$array_marketing    =   $objCommonSelection->get_marketing();

$array_legal_client_marketing    =   array();
$array_legal_client_marketing    =   $objCommonSelection->get_marketing_legal_client();

// $testdar= $objCommonSelection->get_client(4);

// print_r($testdar);
$array_legal_case    =   array();
$array_legal_case = $objLegalCase->get_legal_case();

$array_legal_clients = array();
$array_legal_clients = $objClients->Get_Client_Information(null, null, null, 'A');


$actve_sub_menu = 'dashboard';
$body   =   "list.tpl";