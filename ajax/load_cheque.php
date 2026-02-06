<?php
/**
 * API Endpoint for managing cheques (list, delete, load total).
 *
 * Handles:
 * - Listing cheques
 * - Deleting a cheque
 * - Loading total amounts
 *
 * Requires user session with `LOGIN_LEGAL_ID`
 */

header('Content-Type: application/json');
error_reporting(0);
ini_set('display_errors', 1);
session_start();

// Include necessary files
include_once("../lib/config.php");
include_once("../lib/class/class.dbcon.php");
include_once("../lib/class/class.legal_cheque.php");
include_once("../lib/class/class.legal_client.php");

/**
 * Helper function to send JSON response and exit
 *
 * @param bool        $success Response status
 * @param string      $status  Status text (success/error)
 * @param string      $message Message to return
 * @param array|null  $data    Optional data
 *
 * @return void
 */
function sendResponse(bool $success, string $status, string $message, ?array $data = null): void
{
    $response = [
        'success' => $success,
        'status'  => $status,
        'message' => $message
    ];

    if (!is_null($data)) {
        $response['data'] = $data;
    }

    echo json_encode($response);
    exit;
}

// Check for valid session
if (!isset($_SESSION['LOGIN_LEGAL_ID'])) {
    sendResponse(false, 'error', 'Unauthorized access.');
}

$objCheque = new Cheque();

// Get request parameters safely
$parent_id          = $_GET['parent_id'] ?? null;
$alphabet           = $_GET['alphabet'] ?? null;
$selectedChequeType = $_GET['selectedChequeType'] ?? null;
$list_module        = $_GET['list_module'] ?? null;

// Determine type based on list_module
$type = null;
switch ($list_module) {
        case 'client':
        $type = 'C';
        break;
        case 'case':
        $type = 'CA';
        break;
}

// Ensure required parameters
if (!$parent_id && !$alphabet) {
    sendResponse(false, 'error', 'ID is required.');
}

// Process request based on $alphabet
if ($alphabet === 'list') {

    /**
     * LIST CHEQUES
     */
    $array_list = $objCheque->get_cheque('', $parent_id, $type, $selectedChequeType);
    if($array_list){
    sendResponse(true, 'success', 'success', $array_list);
    }else {
        sendResponse(false, 'error', 'No cheque data available.');
    }


} elseif ($alphabet === 'delete') {

    /**
     * DELETE CHEQUE
     */

    // Validate ID
    $id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
    if ($id <= 0) {
        sendResponse(false, 'error', 'Invalid Cheque ID.');
    }

    $array_list = $objCheque->get_cheque($id)[0] ?? null;

    if ($array_list) {

        // Prepare data for deletion
        $input_data = [
            'id'        => $id,
            'status'    => 'D',
            'update_by' => $_SESSION['LOGIN_LEGAL_ID'],
            'update_on' => date('Y-m-d H:i:s')
        ];

        $filePath  = $array_list['cheque_name'] ?? '';
        $uploadDir = '../uploads/all_cheque/' . $filePath;

        // Attempt to delete
        if ($objCheque->Delete_Cheque($id, $input_data)) {

            // Delete file if exists
            if (!empty($filePath) && file_exists($uploadDir)) {
                unlink($uploadDir);
            }

            sendResponse(true, 'success', $uploadDir . ' Cheque details deleted successfully.');

        } else {
            // Log error for debugging
            error_log("Cheque deletion failed for ID: $id");

            sendResponse(false, 'error', '❌ Error: Please try again.');
        }

    } else {
        sendResponse(false, 'error', '❌ Please try again! Data not found.');
    }

} elseif ($alphabet === 'loadTotal') {

    /**
     * LOAD TOTAL AMOUNTS
     */
    $array_total    = array();
    $array_total    = $objCheque->get_cheque_total($parent_id, $type)[0] ?? [];
    $objClients     =   new Clients();

    $total_outstanding      =0.00;
    $outstanding_cheque     =0.00;
    $outstanding_without_cheque=0.00;

    if($array_total['Total1']>0)
    $outstanding_cheque  = $array_total['Total1'];
    if($array_total['Total2']>0)
    $outstanding_without_cheque = $array_total['Total2'];

    $total_outstanding = floatval($outstanding_cheque) + ($outstanding_without_cheque);




    $data_input     = [
        'total_outstanding' => $total_outstanding ?? 0.00,
        'outstanding_cheque' => $outstanding_cheque ?? 0.00,
        'outstanding_without_cheque' => $outstanding_without_cheque ?? 0.00
    ];
    if($parent_id>0 && $type!=''){
        $objClients->Update_Cheque_OutStanding($parent_id,$data_input);
    }


    // Return the total amounts
    if (empty($array_total)) {
        $array_total = [
            'Total1' => 0.00,
            'Total2' => 0.00
        ];
    }
    echo json_encode([
        'success' => true,
        'Total1'  => $array_total['Total1'] ?? 0.00,
        'Total2'  => $array_total['Total2'] ?? 0.00,
        'OutstandingTotal'  => $total_outstanding ?? 0.00,
        'message' => 'Total amounts loaded successfully.'
    ]);
    exit;

}
