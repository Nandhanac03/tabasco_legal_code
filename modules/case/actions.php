<?php
ob_start();
session_start();
# including files here
include_once("lib/config.php");
include_once("lib/class/class.dbcon.php");
include_once("lib/class/class.legal_case.php");
include_once("lib/class/class.legal_case_root_actions.php");

$objLegalCase = new LegalCase();
$objcaseRootAction = new CaseRootAction();


$edit_id = trim($_GET['param1']);
$action = trim($_GET['action']);

$legal_case = $objLegalCase->get_case($edit_id);
$active_legal_id = $legal_case[0]['active_legal_id'];

$case_filter = array();
$case_filter['created_from'] = 'CA';
$case_filter['active_legal_id'] = $active_legal_id ;
$case_filter['case_id'] = $edit_id;
$case_roots = $objcaseRootAction->get_case_root('', $case_filter);

// echo '<pre>';
// print_r($case_roots);
// exit;
$body   =   "actions.tpl";
