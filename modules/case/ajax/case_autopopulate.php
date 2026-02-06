<?php

header('Content-Type: application/json');

error_reporting(0);

ini_set('display_errors', 1);

session_start();



include_once("../../../lib/config.php");

include_once("../../../lib/class/class.dbcon.php");

include_once("../../../lib/class/class.legal_case.php");

include_once("../../../lib/class/class.legal_court.php");

include_once("../../../lib/class/class.legal_category.php");
include_once("../../../lib/class/class.legal_active_legals.php");
include_once("../../../lib/class/class.legal_cheque.php");
$objCheque =   new Cheque();
$objLegalCase =   new LegalCase();
$objActiveLegal =   new ActiveLegal();


if ($_POST['Active_legal_id']) {
    $activeLegal = $objActiveLegal->Get_ActiveLegal_Information(['id' => $_POST['Active_legal_id']]);
    
   
    $with_client = $objCheque->get_cheque_total($activeLegal[0]['client'], 'C');
    $wit_case    = $objCheque->get_cheque_total($activeLegal[0]['client'], 'CA');
    
    // Safely extract values from both queries
    $with_client_total1 = isset($with_client[0]['Total1']) ? (float)$with_client[0]['Total1'] : 0;
    $with_client_total2 = isset($with_client[0]['Total2']) ? (float)$with_client[0]['Total2'] : 0;

    $wit_case_total1 = isset($wit_case[0]['Total1']) ? (float)$wit_case[0]['Total1'] : 0;
    $wit_case_total2 = isset($wit_case[0]['Total2']) ? (float)$wit_case[0]['Total2'] : 0;

    // Combine totals
    $outstanding_cheque         = $with_client_total1 + $wit_case_total1;
    $outstanding_without_cheque = $with_client_total2 + $wit_case_total2;
    $total_outstanding          = $outstanding_cheque + $outstanding_without_cheque;
    $value = [];
    // Add new fields to result object
    $value['outstanding_cheque']         = $outstanding_cheque;
    $value['outstanding_without_cheque'] = $outstanding_without_cheque;
    $value['total_outstanding']          = $total_outstanding;
    
    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($value, JSON_PRETTY_PRINT);
    
}


