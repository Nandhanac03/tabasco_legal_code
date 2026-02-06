<?php
ob_start();
session_start();
# including files here
include_once("lib/config.php");
include_once("lib/class/class.dbcon.php");
include_once("lib/class/class.legal_common_selection.php");
include_once("lib/class/class.legal_expense.php");
include_once("lib/class/class.legal_cheque.php");
$objCheque =   new Cheque();
$objExpense = new Expense();
$objCommonSelection = new CommonSelection();
include_once("lib/class/class.legal_client.php");
$objClients = new Clients();
include_once("lib/class/class.legal_collection.php");
$objCollection = new Collection();

$array_clients    =   $objClients->Get_Client_Information();

$array_expenses   =   $objExpense->get_expense();
$array_collection = $objCollection->get_collection();

if ($array_expenses) {
    foreach ($array_expenses as $key => $value) {
        $with_client = $objCheque->get_cheque_total($value['legal_client_id'], 'C');
        $wit_case    = $objCheque->get_cheque_total($value['legal_client_id'], 'CA');

        // Safely extract values from both queries
        $with_client_total1 = isset($with_client[0]['Total1']) ? (float)$with_client[0]['Total1'] : 0;
        $with_client_total2 = isset($with_client[0]['Total2']) ? (float)$with_client[0]['Total2'] : 0;

        $wit_case_total1 = isset($wit_case[0]['Total1']) ? (float)$wit_case[0]['Total1'] : 0;
        $wit_case_total2 = isset($wit_case[0]['Total2']) ? (float)$wit_case[0]['Total2'] : 0;

        // Combine totals
        $outstanding_cheque         = $with_client_total1 + $wit_case_total1;
        $outstanding_without_cheque = $with_client_total2 + $wit_case_total2;
        $total_outstanding          = $outstanding_cheque + $outstanding_without_cheque;
       
        // Add new fields to result object
        $array_expenses[$key]['final_outstanding_cheque']         = $outstanding_cheque;
        $array_expenses[$key]['final_outstanding_without_cheque'] = $outstanding_without_cheque;
        $array_expenses[$key]['final_total_outstanding']          = $total_outstanding;
    }
}

if ($array_collection) {
    foreach ($array_collection as $key => $value) {
        $with_client = $objCheque->get_cheque_total($value['legal_client_id'], 'C');
        $wit_case    = $objCheque->get_cheque_total($value['legal_client_id'], 'CA');

        // Safely extract values from both queries
        $with_client_total1 = isset($with_client[0]['Total1']) ? (float)$with_client[0]['Total1'] : 0;
        $with_client_total2 = isset($with_client[0]['Total2']) ? (float)$with_client[0]['Total2'] : 0;

        $wit_case_total1 = isset($wit_case[0]['Total1']) ? (float)$wit_case[0]['Total1'] : 0;
        $wit_case_total2 = isset($wit_case[0]['Total2']) ? (float)$wit_case[0]['Total2'] : 0;

        // Combine totals
        $outstanding_cheque         = $with_client_total1 + $wit_case_total1;
        $outstanding_without_cheque = $with_client_total2 + $wit_case_total2;
        $total_outstanding          = $outstanding_cheque + $outstanding_without_cheque;
       
        // Add new fields to result object
        $array_collection[$key]['final_outstanding_cheque']         = $outstanding_cheque;
        $array_collection[$key]['final_outstanding_without_cheque'] = $outstanding_without_cheque;
        $array_collection[$key]['final_total_outstanding']          = $total_outstanding;
    }
}



// echo '<pre>';print_r($array_clients); 
// echo '<pre>';print_r($array_collection);
// exit; 

// print_r($testdar);
$array_users = array();

$array_users = $objCommonSelection->get_all_users('yes', '21,1');


$body = "list.tpl";