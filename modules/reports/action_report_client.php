<?php
ob_start();
session_start();
if (LEGAL_AUTH_VIEW==false){
    header("Location: ".ROOT_DIR."permission_denied.php");
    exit();
}
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
include_once("lib/class/class.legal_temp_case.php");

$objTempLegalCase = new LegalTempCase();
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

// print_r($array_clients);
// exit();

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

        $legal_case = $objLegalCase->get_case('', $id);
        $legal_precase = $objTempLegalCase->getTempCase(['active_legal_id' => $id]);
        // echo '<pre>';
        // print_r($legal_precase);
        // exit;
        if ($legal_case) {
            foreach ($legal_case as $keycase => $case) {
                $total_collection = $objCollection->total_collection($case['active_legal_id'], $case['id']);
                $legal_case[$keycase]['total_collection'] = $total_collection;
                $total_Expense = $objExpense->total_expense($case['active_legal_id'], $case['id']);
                $legal_case[$keycase]['total_Expense'] = $total_Expense;
            }
        }
        $label_array = [
            'third_party' => 'Third Party',
            'debt_collector' => 'Debt Collector',
            'legal_firm' => 'Legal Firm',
            'legal_team' => 'Legal Team'
        ];
        $shifted_records = $objActiveLegal->get_shifting('', $id, '', true);

        if (!empty($shifted_records)) {
            $party_name = '';
            foreach ($shifted_records as $key => $record) {
                if ($record['legal_type'] == 'debt_collector') {
                    if (!empty($all_debt_collector)) {
                        foreach ($all_debt_collector as $debt_collector) {
                            if ($debt_collector['id'] == $record['party_name']) {
                                $shifted_records[$key]['party_name_label'] = $debt_collector['name'];
                            }
                        }
                    }
                }
                if ($record['legal_type'] == 'third_party') {
                    if (!empty($all_third_party)) {
                        foreach ($all_third_party as $third_party) {
                            if ($third_party['id'] == $record['party_name']) {
                                $shifted_records[$key]['party_name_label'] = $third_party['name'];
                            }
                        }
                    }
                }
                if ($record['legal_type'] == 'legal_firm') {
                    if (!empty($all_legal_firm)) {
                        foreach ($all_legal_firm as $legal_firm) {
                            if ($legal_firm['id'] == $record['party_name']) {
                                $shifted_records[$key]['party_name_label'] = $legal_firm['name'];
                            }
                        }
                    }
                }
                // $shifted_records[$key]['party_name_label']='$party_name';
            }
        }

        break;
}





// echo '<pre>';print_r($active_legal); exit;
// echo '<pre>';print_r($legal_case);
// exit; 

// print_r($testdar); 
$array_users = array();

$array_users = $objCommonSelection->get_all_users('yes', '21,1');


$actve_sub_menu =   'action_report';

$body = "action_report_client.tpl";
