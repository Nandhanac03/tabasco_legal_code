<!-- list -->
<?php
ob_start();
session_start();
# including files here
include_once("lib/config.php");
include_once("lib/class/class.dbcon.php");
include_once("lib/class/class.legal_active_legals.php");
include_once("lib/class/class.legal_case.php");
include_once("lib/class/class.legal_cheque.php");

$objActiveLegal =   new ActiveLegal();
$objLegalCase =   new LegalCase();
$objCheque =   new Cheque();

if (LEGAL_AUTH_VIEW == false) {
    header("Location: " . ROOT_DIR . "permission_denied.php");
    exit();
}

$action = $_GET['action'];
$id = $_GET['param1'];

$legal_case = $objLegalCase->get_case_info($id);
$activeLegalId = $legal_case[0]['active_legal_id'];
$activeLegal = $objActiveLegal->Get_ActiveLegal_Information(['id' => $activeLegalId]);
$legal_case = $objLegalCase->get_case($id);

// echo '<pre>';
// print_r($legal_case[0]['lawyer']);
// exit;

if ($activeLegal) {
    foreach ($activeLegal as $key => $value) {

        $with_client = $objCheque->get_cheque_total($value['client'], 'C');
        $wit_case    = $objCheque->get_cheque_total($value['client'], 'CA');
        $with_client_total1 = isset($with_client[0]['Total1']) ? (float)$with_client[0]['Total1'] : 0;
        $with_client_total2 = isset($with_client[0]['Total2']) ? (float)$with_client[0]['Total2'] : 0;
        $wit_case_total1 = isset($wit_case[0]['Total1']) ? (float)$wit_case[0]['Total1'] : 0;
        $wit_case_total2 = isset($wit_case[0]['Total2']) ? (float)$wit_case[0]['Total2'] : 0;

        // Combine totals
        $outstanding_cheque         = $with_client_total1 + $wit_case_total1;
        $outstanding_without_cheque = $with_client_total2 + $wit_case_total2;
        $total_outstanding          = $outstanding_cheque + $outstanding_without_cheque;

        // Add new fields to result object


        $activeLegal[$key]['final_outstanding_cheque']         = $outstanding_cheque;
        $activeLegal[$key]['final_outstanding_without_cheque'] = $outstanding_without_cheque;
        $activeLegal[$key]['final_total_outstanding']          = $total_outstanding;
    }
}

// echo '<pre>';
// print_r($activeLegal);
// exit;




$body   =   "list.tpl";
