<?php
if (LEGAL_AUTH_VIEW==false){
    header("Location: ".ROOT_DIR."permission_denied.php");
    exit();
}


include_once("lib/class/class.legal_master.php");



$ObjMasterdata   =   new Masterdata();



include_once("lib/config.php");
include_once("lib/class/class.dbcon.php");
include_once("lib/class/class.legal_common_selection.php");

$objCommonSelection = new CommonSelection();

$array_users = array();

$array_users = $objCommonSelection->get_all_users('yes', '21,1');



$array_legal_client_marketing    =   array();
$array_legal_client_marketing    =   $objCommonSelection->get_marketing_legal_client();

include_once("lib/class/class.legal_case.php");
$objLegalCase = new LegalCase();
include_once("lib/class/class.legal_client.php");
$objClients = new Clients();

$array_legal_case    =   array();
$array_legal_case = $objLegalCase->get_legal_case();

$array_legal_clients = array();
$array_legal_clients = $objClients->Get_Client_Information(null, null, null, 'A');



$actve_sub_menu =   'total_legal_report';



$body           =   "total_legal_report.tpl";



?>