<?php
ob_start();
session_start();
# including files here
include_once("lib/config.php");
include_once("lib/class/class.dbcon.php");
include_once("lib/class/class.legal_case.php");
$objLegalCase = new LegalCase();
include_once("lib/class/class.legal_expense.php");
$objExpense = new Expense();
$edit_id = trim($_GET['param1']);
$action = trim($_GET['action']);

$legal_case = $objLegalCase->get_case($edit_id);


$client_id = $legal_case[0]['client_id'];
$active_legal_id = $legal_case[0]['active_legal_id'];
$case_id = $legal_case[0]['id'];
$filter = [];
$filter['client_id'] = $client_id;
$filter['active_legal_id'] = $active_legal_id;
$filter['case_id'] = $edit_id;
$expenses = $objExpense->get_expense('', $filter);

// echo '<pre>';
// print_r($expense);
// exit;



$body   =   "expense.tpl";