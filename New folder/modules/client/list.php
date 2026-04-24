<?php
if (LEGAL_AUTH_VIEW==false){
    header("Location: ".ROOT_DIR."permission_denied.php");
    exit();
}
include_once("lib/class/class.legal_common_selection.php");
$objCommonSelection =   new CommonSelection();

include_once("lib/class/class.legal_client.php");
$objClients = new Clients();


$array_marketing    =   array();
$array_marketing    =   $objCommonSelection->get_marketing();

$array_legal_client_marketing    =   array();
$array_legal_client_marketing    =   $objCommonSelection->get_marketing_legal_client();

// $testdar= $objCommonSelection->get_client(4);

// print_r($testdar);



$actve_sub_menu = 'dashboard';
$body   =   "list.tpl";