<?php
ob_start();
session_start();

include_once("lib/class/class.legal_case.php");
$objLegalCase = new LegalCase();

$edit_id = trim($_GET['param1'] ?? '');

if (!$edit_id) {
    header("Location: " . ROOT_DIR . "case/list.html");
    exit;
}

// Fetch current legal case info to know the client/active_legal
$current_legal_case = $objLegalCase->get_case($edit_id);
$activeLegalId = $current_legal_case[0]['active_legal_id'] ?? '';

include_once("lib/class/class.legal_client.php");
$objClients = new Clients();
$array_legal_clients = $objClients->Get_Client_Information('', '', '', 'A');

$body = "relatedcases.tpl";
?>
