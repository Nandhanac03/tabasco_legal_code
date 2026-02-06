<?php
header('Content-Type: application/json');
error_reporting(0);
ini_set('display_errors', 1);
session_start();
// Include necessary files
include_once("../lib/config.php");
include_once("../lib/class/class.dbcon.php");

include_once("../lib/class/class.legal_plantiff.php");
$ObjContact  =   new Plantiff();

$parent_id      = $_GET['parent_id'] ?? null;
$list_module    = $_GET['list_module'] ?? null;
$list_page      = $_GET['list_page'] ?? null;
$alphabet       = $_GET['alphabet'] ?? null;



$array_list     =   array();

$parentType='';
switch ($list_module) {
        case 'client':
            $parentType = 'C';
        break;
        case 'thirdparty':
            $parentType = 'TP';
        break;
        case 'legalfirm':
            $parentType = 'LF';
        break;
        case 'activelegal':
            $parentType = 'AL';
        break;
}

if (!$parent_id && !$list_module && !$list_page && !$parentType && !$alphabet) {
    echo json_encode(['success' => false, 'message' => ' Please try again ! Parameters not found .']);
    exit;
}

if($alphabet=='list'){
    $array_list =   $ObjContact->get_plantiff('',$parent_id,$parentType);

    echo json_encode([
        'success' => true,
        'data' => $array_list
    ]);
}else if($alphabet=='delete'){
    $id         =   trim($_REQUEST['id']);
    $array_data =   array();
    $array_data =   $ObjContact->get_plantiff($id)[0];
    if(isset($array_data)){
        $input_data =   array();
        $input_data['id']               =   $id;
        $input_data['status']           =   'D';
        $input_data['update_by']        =   $_SESSION['LOGIN_LEGAL_ID'];
        $input_data['update_on']        =   date('Y-m-d H:i:s');
        if($ObjContact->Delete_Plantiff($id,$input_data)){
            echo json_encode(['success' => true, 'message' => ' plantiff deleted successfully.']);
        }else{
            echo json_encode(['success' => false, 'message' => 'Error:  Please try again. ']);
        }

    }else{
        echo json_encode(['success' => false, 'message' => ' Please try again ! Data not found .']);
        exit;
    }

}


