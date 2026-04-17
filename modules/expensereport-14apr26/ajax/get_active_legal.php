<?php
ob_start();
session_start();
error_reporting(0);

include_once("../../../lib/config.php");
include_once("../../../lib/class/class.dbcon.php");
include_once("../../../lib/class/class.legal_active_legals.php");
include_once("../../../lib/class/class.legal_case.php");
include_once("../../../lib/class/class.legal_collection.php");

$objActiveLegal = new ActiveLegal();
$objLegalCase = new LegalCase();
$objCollection = new Collection();


if($_POST){
    if($_POST['action'] == 'find_active_legal' && $_POST['client_id']){

        $active_legal = $objActiveLegal->Get_ActiveLegal_Information(['client' => $_POST['client_id']]);

        $result = [];
        if ($active_legal) {
            foreach ($active_legal as $value) {
                $total_collection = $objCollection->total_collection($value['id']);
                $result[] = [
                    'id'   => $value['id'],
                    'code' => $value['code'],
                    'claim_amount' => $value['claim_amount'] ?? 0,
                    'total_collection' => $total_collection
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
                $total_collection = $objCollection->total_collection('', $value['id']);
                $result[] = [
                    'id'   => $value['id'],
                    'case_number' => $value['case_number'],
                    'claim_amount' => $value['total_outstanding'] ?? 0,
                    'total_collection' => $total_collection
                ];
            }
        }
        
        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
         
     }
}

