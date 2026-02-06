<?php
ob_start();
session_start();
error_reporting(0);

include_once("../../../lib/config.php");
include_once("../../../lib/class/class.dbcon.php");
include_once("../../../lib/class/class.legal_active_legals.php");
include_once("../../../lib/class/class.legal_case.php");

$objActiveLegal = new ActiveLegal();
$objLegalCase = new LegalCase();


if($_POST){
    if($_POST['action'] == 'find_active_legal' && $_POST['client_id']){

        $active_legal = $objActiveLegal->Get_ActiveLegal_Information(['client' => $_POST['client_id']]);

        $result = [];
        if ($active_legal) {
            foreach ($active_legal as $value) {
                $result[] = [
                    'id'   => $value['id'],
                    'code' => $value['code']
                ];
            }
        }
        
        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
        
    }

    if($_POST['action'] == 'find_active_legal_cases' && $_POST['activeLegalId']){
        
        $case = $objLegalCase->get_case('',$_POST['activeLegalId']);

        $result = [];
        if ($case) {
            foreach ($case as $value) {
                $result[] = [
                    'id'   => $value['id'],
                    'case_number' => $value['case_number']
                ];
            }
        }
        
        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
         
     }
}

