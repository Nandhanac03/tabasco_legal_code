<?php
ob_start();
session_start();
# including files here
include_once("lib/config.php");
include_once("lib/class/class.dbcon.php");
include_once("lib/class/class.legal_active_legals.php");
include_once("lib/class/class.legal_case.php");

$objActiveLegal =   new ActiveLegal();
$objLegalCase =   new LegalCase();
$id = trim($_GET['param1']);
$action = trim($_GET['action']);

$edit_id = trim($_GET['param1']);
$action = trim($_GET['action']);

if (!$edit_id) {
    header("location: " . ROOT_DIR . "permission_denied.php");
    exit;
}
$legal_case = $objLegalCase->get_case_info($id);
$activeLegalId = $legal_case[0]['active_legal_id'];

$body   =   "case_hearing.tpl";