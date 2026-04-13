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


if (isset($_POST)) {

    // Validate CSRF token (if using)
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        echo json_encode(["status" => "error", "message" => "Invalid CSRF token."]);
        exit();
    }




    // Sanitize inputs
    $marketing_id = trim($_POST['marketing_id']);
    $client_id = trim($_POST['client_id']);
    $contact_number = trim($_POST['contact_number']);
    $total_outstanding = trim($_POST['total_outstanding']);
    $outstanding_cheque = trim($_POST['outstanding_cheque']);
    $outstanding_without_cheque = trim($_POST['outstanding_without_cheque']);

    $client_Text = trim($_POST['client_Text']);

    // Validate inputs
    if ($marketing_id == '' && $client_id == '') {
        echo json_encode(['success' => false, "status" => "error", "message" => VALIDATION_MSG]);
        exit();
    }

    // Database insert using prepared statements
    $input_data = array();
    $input_data['marketing']    = $marketing_id;
    $input_data['refer_id']     = $client_id;
    $input_data['name']         = $client_Text;

    $input_data['total_outstanding']            = $total_outstanding;
    $input_data['outstanding_cheque']           = $outstanding_cheque;
    $input_data['outstanding_without_cheque']   = $outstanding_without_cheque;
    $input_data['mobile_number']                = $contact_number;

    $client_code                = $objClients->Get_Last_Client_ID();
    $input_data['code']         = $client_code;

    if(!$client_code){
        echo json_encode(['success' => false, "status" => "error", "message" => "Failed to generate client code.Please refresh the page and try again."]);
        exit();
    }
    if ($objClients->Manage_Client_information($input_data, '')) {
        if ($objClients->_inserted_id) {
            $id = $objClients->_inserted_id;
            if ($id) {
                $_SESSION['PAGE_SUCCESS'] = 'You have successfully created a client !';
                
               // $objlogger->logActivity('CREATE', 'Client', $id, "Created new client: {$client_Text}", null, $input_data);

                echo json_encode(['success' => true, 'status' => 'success', 'message' => 'OKAY', 'id' => $id]);
                exit;
            }
        } else {
            echo json_encode(['success' => false, "status" => "error", "message" => "Failed to save client information."]);
            exit();
        }

    } else {
        echo json_encode(['success' => false, "status" => "error", "message" => "Failed to save client information."]);
        exit();
    }


} else {
    echo json_encode(['success' => false, "status" => "error", "message" => "Invalid request method."]);
    exit;
}

