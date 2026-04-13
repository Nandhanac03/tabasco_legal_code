<?php
// Prevent any accidental whitespace or errors from breaking JSON
ob_start();
session_start();

// Set header to JSON
header('Content-Type: application/json');

// Disable error display for AJAX to prevent breaking JSON (log them instead)
error_reporting(E_ALL);
ini_set('display_errors', 0); 

include_once("../lib/config.php");
include_once("../lib/class/class.dbcon.php");
include_once("../lib/class/class.legal_plantiff.php");


$ObjContact = new Plantiff();
//$objlogger  = new LegalActivityLog();
$response = array('status' => 'error', 'message' => 'Internal Server Error');

if ($_POST) {
    // 1. CSRF token validation
    if (!isset($_POST['csrf_token']) || !isset($_SESSION['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid CSRF token.']);
        exit;
    }

    // 2. Collect and Sanitize inputs
    $parentID       = isset($_POST['hid_parentID']) ? htmlspecialchars($_POST['hid_parentID']) : null;
    $plantiffName    = isset($_POST['plantiffName']) ? htmlspecialchars($_POST['plantiffName']) : null;
    $postmodule     = isset($_POST['hid_module']) ? htmlspecialchars($_POST['hid_module']) : null;
    $postpage       = isset($_POST['hid_page']) ? htmlspecialchars($_POST['hid_page']) : null;
    $plantiffNo = isset($_POST['plantiffNo'])   ? htmlspecialchars($_POST['plantiffNo'])   : null;
    $plantiffEmail          = isset($_POST['plantiffEmail'])? htmlspecialchars($_POST['plantiffEmail']) : null;

    // 3. Validation
    if (!$postmodule || !$postpage || !$parentID || !$plantiffName) {
        echo json_encode(['status' => 'error', 'message' => 'Please fill in all required fields.']);
        exit;
    }

    // 4. Map Module to Type
    $parentType = 'O'; // Default Other
    switch ($postmodule) {
        case 'client':        $parentType = 'C';  break;
        case 'thirdparty':    $parentType = 'TP'; break;
        case 'legalfirm':     $parentType = 'LF'; break;
        case 'debtcollector': $parentType = 'DC'; break;
        case 'activelegal':   $parentType = 'AL'; break;
    }

    // 5. Prepare data for database
    $input_data = array();
    $input_data['parent_id']      = $parentID;
    $input_data['parent_type']    = $parentType;
    $input_data['name']           = $plantiffName;
    $input_data['contact_number'] = $plantiffNo;
    $input_data['email']          = $plantiffEmail;
    $input_data['create_by']      = $_SESSION['LOGIN_LEGAL_ID'] ?? 0;
    $input_data['create_on']      = date('Y-m-d H:i:s');

    // 6. Execute Database Method
    if ($ObjContact->manage_plantiff($input_data)) {
        $response['status'] = 'success';
        $response['message'] = 'Plaintiff added successfully.';
       // $objlogger->logActivity('CREATE', 'Plaintiff', null, "Added plaintiff: {$plantiffName} for parent ID: {$parentID} ({$parentType})", null, $input_data);
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Database Error: Could not save the record.';
    }

    // Clear buffer and send clean JSON
    ob_clean();
    echo json_encode($response);
    exit;
}
?>