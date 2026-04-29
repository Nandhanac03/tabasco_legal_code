<?php
ob_start();
session_start();

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

$actve_sub_menu =   'statementbase_report_list';
$body = "statementbase_report_list.tpl";