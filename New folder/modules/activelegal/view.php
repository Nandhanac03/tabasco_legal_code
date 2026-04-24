<?php
ob_start();
session_start();
# including files here
include_once("lib/config.php");
include_once("lib/class/class.dbcon.php");
include_once("lib/class/class.legal_active_legals.php");
include_once("lib/class/class.legal_case.php");
include_once("lib/class/class.legal_third_party.php");
include_once("lib/class/class.legal_debt_collector.php");
include_once("lib/class/class.legal_firm.php");
include_once("lib/class/class.legal_case_root_actions.php");

$objActiveLegal = new ActiveLegal();
$objLegalCase = new LegalCase();
$objThirdParty = new thirdParty();
$objDebtCollector = new DebtCollector();
$objLegalFirm = new LegalFirm();
$objcaseRootAction = new CaseRootAction();
include_once("lib/class/class.legal_temp_case.php");
$objTempLegalCase = new LegalTempCase();

$action = $_GET['action'];
$id = $_GET['param1'];

if (!$action || !$id) {
    header("location: " . ROOT_DIR . "activelegal/list.html");
    exit;
}
switch ($action) {
    case 'view':

        $_SESSION['ACTIVE_LEGAL_ID'] = $id;
        $filter = ['id' => $id];
        $case_filter = [];
        $active_legal = $objActiveLegal->Get_ActiveLegal_Information($filter);
        $all_third_party = $objThirdParty->get_legal_third_Information('', '', '', 'A');
        $all_debt_collector = $objDebtCollector->getDebtCollectorInfo();
        $all_legal_firm = $objLegalFirm->getLegalFirmInformation();

        $legal_case = $objLegalCase->get_case_info('', $id);
        $temp_legalcase =   $objTempLegalCase->getTempCase(['active_legal_id'=>$id]);

        // echo '<pre>';
        // print_r($legal_case);
        // exit;



        if ($legal_case) {
            // Define which subcategories you want and where to store them
            $subcategories = [
                1 => 'first_instance_description',   // First Instance Judgment
                4 => 'execution_decision_description' // Execution Decision
            ];

            foreach ($legal_case as $key => $case) {
                foreach ($subcategories as $subcategoryId => $fieldName) {
                    $filter = [
                        'case_id' => $case['id'],
                        'action_subcategory_id' => $subcategoryId
                    ];
                    $case_roots = $objcaseRootAction->get_case_root('', $filter);

                    if ($case_roots) {
                        $legal_case[$key][$fieldName] = $case_roots[0]['description'];
                    }
                }
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
// echo"<pre>";print_r($legal_case);exit;


$body   =   "view.tpl";
