<?php
header('Content-Type: application/json');
error_reporting(0);
ob_clean();

include_once("../../../lib/config.php");
include_once("../../../lib/class/class.dbcon.php");
include_once("../../../lib/class/class.legal_client.php");

$objClients = new Clients();

$marketing_id = trim($_POST['marketing_id'] ?? '');
$client_name  = trim($_POST['client_name'] ?? '');

if (empty($marketing_id) || empty($client_name)) {
    echo json_encode(['success' => false, 'message' => 'Marketing ID and Client Name are required.']);
    exit;
}

// Prepare data to insert
$input_data = [
    'name' => $client_name,
    'marketing' => $marketing_id,
    'client_from' => 'legal',
    'status' => 'A'
];

// Check if client already exists with the same name
$existing = $objClients->Get_Client_Information('', $client_name, '', '', '', 0, 0, '', '', '', '');
if (!empty($existing) && is_array($existing) && !empty($existing[0])) {
    echo json_encode(['success' => false, 'message' => 'Client already exists']);
    exit;
}

if ($objClients->Manage_Client_information($input_data, '')) {
    $inserted_id = $objClients->_inserted_id;
    if ($inserted_id) {
        echo json_encode([
            'success' => true, 
            'message' => 'Client added successfully', 
            'client_id' => $inserted_id, 
            'client_name' => $client_name
        ]);
        exit;
    }
}

echo json_encode(['success' => false, 'message' => 'Failed to add client.']);
