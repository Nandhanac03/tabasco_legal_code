<?php
ob_start();
session_start();
# including files here
include_once("lib/config.php");
include_once("lib/class/class.dbcon.php");
include_once("lib/class/class.legal_expense.php");
$objExpense = new Expense();
include_once("lib/class/class.legal_collection.php");

$objCollection = new Collection();
include_once("lib/class/class.legal_active_legals.php");
include_once("lib/class/class.legal_case.php");
$objActiveLegal = new ActiveLegal();
$objLegalCase = new LegalCase();
include_once("lib/class/class.legal_fees_type.php");
$objFees_type=   new LegalFees_type();
$fees_types = $objFees_type->get_feesType();
$action = $_GET['action'];
$caseid = $_GET['param1'];


$legal_case = $objLegalCase->get_case($caseid);
$active_legal = $objActiveLegal->Get_ActiveLegal_Information(['id' => $legal_case[0]['active_legal_id']]);

// echo '<pre>';print_r($active_legal);
// echo '<pre>';print_r($legal_case);exit;


$client_id = $active_legal[0]['client'];
$active_legal_id = $active_legal[0]['id'];
$case_id = $legal_case[0]['id'];
$filter = [];
$filter['client_id'] = $client_id;
$filter['active_legal_id'] = $active_legal_id;
$filter['case_id'] = $case_id;

$collection = $objCollection->get_collection('', $filter);
$expense = $objExpense->get_expense('', $filter);

// echo '<pre>';print_r($expense);exit;


$body   =   "claimamount.tpl";
