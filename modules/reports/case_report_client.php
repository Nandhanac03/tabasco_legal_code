<?php
ob_start();
session_start();
# including files here
include_once("lib/config.php");
include_once("lib/class/class.dbcon.php");
include_once("lib/class/class.legal_common_selection.php");
include_once("lib/class/class.legal_expense.php");
include_once("lib/class/class.legal_cheque.php");
include_once("lib/class/class.legal_active_legals.php");
include_once("lib/class/class.legal_case.php");
include_once("lib/class/class.legal_third_party.php");
include_once("lib/class/class.legal_debt_collector.php");
include_once("lib/class/class.legal_firm.php");
include_once("lib/class/class.casereports.php");

$objTempLegalCase = new CaseReport();
$objActiveLegal = new ActiveLegal();
$objLegalCase = new LegalCase();
$objThirdParty = new thirdParty();
$objDebtCollector = new DebtCollector();
$objLegalFirm = new LegalFirm();
$objCheque =   new Cheque();
$objExpense = new Expense();
$objCommonSelection = new CommonSelection();
include_once("lib/class/class.legal_client.php");
$objClients = new Clients();
include_once("lib/class/class.legal_collection.php");
$objCollection = new Collection();

$array_clients    =   $objClients->Get_Client_Information();


$action = $_GET['action'];
$id = $_GET['param1'];

if (!$action || !$id) {
    header("location: " . ROOT_DIR . "expensereport/list/.html");
    exit;
}

switch ($action) {
    case 'view':
        $active_legal = $objActiveLegal->Get_ActiveLegal_Information(['id' => $id]);
        $all_third_party = $objThirdParty->get_legal_third_Information('', '', '', 'A');
        $all_debt_collector = $objDebtCollector->getDebtCollectorInfo();
        $all_legal_firm = $objLegalFirm->getLegalFirmInformation();
       
        $legal_precase = $objTempLegalCase->getCaseRootActions([
            'active_legal_id' => $id
        ]);

       
        if (!empty($legal_precase)) {
            foreach ($legal_precase as $key => $row) {
               
                $total_collection = $objCollection->total_collection($id, $row['id']);
                $legal_precase[$key]['total_collection'] = $total_collection;

                $total_Expense = $objExpense->total_expense($id, $row['id']);
                $legal_precase[$key]['total_Expense'] = $total_Expense;
            }
        }

        
        $report_data = $legal_precase;
        // echo '<pre>';
        // print_r($legal_precase); 
        // exit();
        break;
}



// echo '<pre>';print_r($active_legal); exit;
// echo '<pre>';print_r($legal_case);
// exit; 

// print_r($testdar); 
$array_users = array();

$array_users = $objCommonSelection->get_all_users('yes', '21,1');


$actve_sub_menu =   'case_report';

$body = "case_report_client.tpl";
