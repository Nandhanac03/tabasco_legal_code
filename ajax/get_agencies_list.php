<?php
header('Content-Type: application/json');
error_reporting(0);
ini_set('display_errors', 1);
session_start();
// Include necessary files
include_once("../lib/config.php");
include_once("../lib/class/class.dbcon.php");

$id = $_POST['id'] ?? null;
$action = $_POST['action'] ?? null;
$array_data = array();
if ($id == null || $action == null) {
    echo json_encode(array('status' => 'error', 'message' => 'Invalid parameters'));
    exit;

} else {
    switch ($id) {
        case '1':
            include_once("../lib/class/class.legal_third_party.php");
            $objthirdParty = new thirdParty();

            $array_data = $objthirdParty->get_legal_third_Information('', '', '', 'A');
            // Convert to desired format
            $result = array_map(function ($item) {
                return [
                    'id' => (string) $item['id'],   // Convert to string if needed
                    'name' => $item['name'],
                    'code' => $item['code']
                ];
            }, $array_data);

            echo json_encode($result, JSON_PRETTY_PRINT);
            break;
        case '2':
            include_once("../lib/class/class.legal_firm.php");
            $ObjLegalFirm = new LegalFirm();
            $filters = array();
            $filters['status'] = 'A';
            $array_data = $ObjLegalFirm->getLegalFirmInformation($filters);

            $result = array_map(function ($item) {
                return [
                    'id' => (string) $item['id'],   // Convert to string if needed
                    'name' => $item['name'],
                    'code' => $item['code']
                ];
            }, $array_data);

            echo json_encode($result, JSON_PRETTY_PRINT);
            break;


        case '3':
            include_once("../lib/class/class.legal_debt_collector.php");
            $ObjDebtCollector = new DebtCollector();
            $filters = array();
            $filters['status'] = 'A';
            $array_data = $ObjDebtCollector->getDebtCollectorInfo($filters);
            // Convert to desired format
            $result = array_map(function ($item) {
                return [
                    'id' => (string) $item['id'],   // Convert to string if needed
                    'name' => $item['name'],
                    'code' => $item['code']
                ];
            }, $array_data);

            echo json_encode($result, JSON_PRETTY_PRINT);
            break;

        case '4':
            include_once("../lib/class/class.legal_users.php");
            $ObjUsersClass = new UsersClass();

            $array_data = $ObjUsersClass->get_all_Users(null, '', 23);
            // Convert to desired format
            $result = array_map(function ($item) {
                return [
                    'id' => (string) $item['user_Id'],   // Convert to string if needed
                    'name' => $item['user_name'],
                    'code' => '',
                ];
            }, $array_data);

            echo json_encode($result, JSON_PRETTY_PRINT);
            break;


    }
}
