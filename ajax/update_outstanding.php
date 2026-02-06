<?php
header('Content-Type: application/json');
error_reporting(0);
ini_set('display_errors', 1);
session_start();
// Include necessary files
include_once("../lib/config.php");
include_once("../lib/class/class.dbcon.php");

include_once("../lib/class/class.legal_client.php");
$objClients = new Clients();
// Get JSON input
$data = json_decode(file_get_contents("php://input"), true);

if ($data) {
    // Process the data
    $param1                 = $data['param1'];
    $totalOutstanding       = $data['total_outstanding'];
    $outstandingCheque      = $data['outstanding_cheque'];
    $outstandingWithoutCheque = $data['outstanding_without_cheque'];

if($param1){
    $array_data           = array();
    $array_data           = $objClients->Get_Client_Information($param1)[0];
    $marketing            = $array_data['marketing'];  // Get marketing from the array

    // Update the outstanding data

    if($marketing>0 && $param1>0){
        $update_array   =   array();
        $update_array['marketing']                      = $marketing;
        $update_array['total_outstanding']              = $totalOutstanding;
        $update_array['outstanding_cheque']             = $outstandingCheque;
        $update_array['outstanding_without_cheque']     = $outstandingWithoutCheque;
        $update_array['update_by']                      = $_SESSION['user_id'];
        $update_array['update_on']                      = date('Y-m-d H:i:s');
        $update_array['refer_id']                       = $param1;
        if($objClients->Manage_Client_information($update_array,$param1)){

            $get_data   =  $objClients->Get_Client_Information($param1)[0];
            $data['total_outstanding']          = $get_data['total_outstanding'];
            $data['outstanding_cheque']         = $get_data['outstanding_cheque'];
            $data['outstanding_without_cheque'] = $get_data['outstanding_without_cheque'];
            $data['status'] = "success";
            $data['message'] = "Outstanding data updated successfully";
        } else {
            $data['status'] = "error";
            $data['message'] = "Failed to update data";
        }

    } else {
        $data['status'] = "error";
        $data['message'] = "Invalid data received";
    }
}else{
    $data['status'] = "error";
    $data['message'] = "Invalid data received";
}


    echo json_encode($data);
    exit;
} else {
    echo json_encode(["status" => "error", "message" => "No data received"]);
    exit;
}

