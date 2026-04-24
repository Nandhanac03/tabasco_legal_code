<?php
ob_start();
session_start();
# including files here
include_once("lib/config.php");
include_once("lib/class/class.dbcon.php");
include_once("lib/class/class.legal_case.php");
include_once("lib/class/class.legal_client.php");

if (LEGAL_AUTH_VIEW == false) {
    header("Location: " . ROOT_DIR . "permission_denied.php");
    exit();
}

$objLegalCase = new LegalCase();
$objClients = new Clients();

$array_legal_case = $objLegalCase->get_legal_case();
$array_legal_clients = $objClients->Get_Client_Information(null, null, null, 'A');

$body = "caseactions.tpl";












