<?php
ob_start();
session_start();
// echo"<pre>";
// print_r($_SESSION);
// exit();
if (LEGAL_AUTH_VIEW==false){
    header("Location: ".ROOT_DIR."permission_denied.php");
    exit();
}
# including files here
include_once("lib/config.php");
include_once("lib/class/class.dbcon.php");

include_once("lib/class/class.legal_case.php");
$objLegalCase = new LegalCase();

include_once("lib/class/class.legal_client.php");
$objClients = new Clients();

$array_legal_case    =   array();
$array_legal_case = $objLegalCase->get_legal_case();

$array_legal_clients = array();
$array_legal_clients = $objClients->Get_Client_Information(null, null, null, 'A');

$actve_sub_menu =   'case_report_list';
$body = "case_report_list.tpl";