<?php
if (LEGAL_AUTH_VIEW==false){
    header("Location: ".ROOT_DIR."permission_denied.php");
    exit();
}
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
include_once("lib/class/class.legal_case_root_actions.php");
$objCaseRootAction = new CaseRootAction();

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
$case_id = $id;
$legal_case = $objLegalCase->get_case($case_id);
$active_legal_id = $legal_case[0]['active_legal_id'];
$active_legal = $objActiveLegal->Get_ActiveLegal_Information(['id' => $active_legal_id]);
if (!$action || !$id) {
    header("location: " . ROOT_DIR . "reports/client_base_action_report_list.html");
    exit;
}



switch ($action) {
    case 'view':
        $all_third_party = $objThirdParty->get_legal_third_Information('', '', '', 'A');
        $all_debt_collector = $objDebtCollector->getDebtCollectorInfo();
        $all_legal_firm = $objLegalFirm->getLegalFirmInformation();

        if ($legal_case) {
            foreach ($legal_case as $keycase => $case) {
                $c_id = $case['id'];
                $total_collection = $objCollection->total_collection($case['active_legal_id'], $case['id']);
                $legal_case[$keycase]['total_collection'] = $total_collection;
                $total_Expense = $objExpense->total_expense($case['active_legal_id'], $case['id']);
                $legal_case[$keycase]['total_Expense'] = $total_Expense;

                $case_actions = $objCaseRootAction->get_case_root('', ['case_id' => $c_id, 'created_from' => 'CA']);

                $filter = [];
                $filter['client_id'] = $case->client_id;
                $filter['active_legal_id'] = $active_legal_id;
                $filter['case_id'] = $c_id;

                $collection = $objCollection->get_collection('', $filter);
                $expenses = $objExpense->get_expense('', $filter);

                $mergedData = [];

                // Format collection data
                foreach ($collection as $col) {
                    $col['collection_amount'] = $col['amount']; // rename field
                    unset($col['amount']); // remove old field
                    $col['data_type'] = 'Collection';
                    $col['fees_type_title'] = 'Claim';

                    $mergedData[] = $col;
                }

                foreach ($case_actions as $caction) {
                    $caction['data_type'] = 'Case Action';
                    $caction['fees_type_title'] = 'Case Action';

                    $mergedData[] = $caction;
                }

                // Format expense data
                foreach ($expenses as $exp) {
                    $exp['expense_amount'] = $exp['amount'];
                    unset($exp['amount']);
                    $exp['data_type'] = 'Expense';
                    $mergedData[] = $exp;
                }

                usort($mergedData, function ($a, $b) {
                    return strtotime($b['date']) <=> strtotime($a['date']);
                });
                

                // echo '<pre>';
                // print_r($mergedData);
                // exit;
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
}



$actve_sub_menu =   'client_base_action';



$body           =   "action_report_with_clain_ex.tpl";