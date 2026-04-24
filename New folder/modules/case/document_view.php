<?php
ob_start();
session_start();
# including files here
include_once("lib/config.php");
include_once("lib/class/class.dbcon.php");
include_once("lib/class/class.legal_master.php");
$ObjMasterdata   =   new Masterdata();
include_once("lib/class/class.legal_active_legals.php");
include_once("lib/class/class.legal_case.php");

$objActiveLegal =   new ActiveLegal();
$objLegalCase =   new LegalCase();
$id = trim($_GET['param1']);
$action = trim($_GET['action']);



if (!$id) {
    header("location: " . ROOT_DIR . "permission_denied.php");
    exit;
}

$array_document_type    =   array();
$array_document_type    =   $ObjMasterdata->get_DocumentType();

$legal_case = $objLegalCase->get_case_info($id);
$activeLegalId = $legal_case[0]['active_legal_id'];

$body   =   "document_view.tpl";
