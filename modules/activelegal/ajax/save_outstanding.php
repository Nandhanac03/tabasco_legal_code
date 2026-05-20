<?php
session_start();
include_once("../../../lib/config.php");
include_once("../../../lib/class/class.dbcon.php");
include_once("../../../lib/class/class.legal_active_legals.php");
include_once("../../../lib/class/class.legal_client.php");


$objActiveLegal = new ActiveLegal();
$objClient = new Clients();

$active_legal_id = $_POST['active_legal_id'] ?? '';
$client_id = $_POST['client_id'] ?? '';
$total_outstanding = $_POST['total_outstanding'] ?? 0;
$outstanding_with_cheque = $_POST['outstanding_with_cheque'] ?? 0;
$outstanding_without_cheque = $_POST['outstanding_without_cheque'] ?? 0;

if(empty($active_legal_id) || empty($client_id)) {
    echo json_encode(['success' => false, 'message' => 'Missing required IDs (Active Legal ID or Client ID)']);
    exit;
}

// 1. Update Active Legal (this automatically triggers logAmountActivity for activelegal)
$activeLegalData = [
    'total_outstanding' => $total_outstanding,
    'outstanding_with_cheque' => $outstanding_with_cheque,
    'outstanding_without_cheque' => $outstanding_without_cheque
];
$objActiveLegal->Manage_ActiveLegal($activeLegalData, $active_legal_id);

// 2. Update Client (disable logging here to prevent duplicate log rows, logging only activelegal)
$clientData = [
    'total_outstanding' => $total_outstanding,
    'outstanding_cheque' => $outstanding_with_cheque,
    'outstanding_without_cheque' => $outstanding_without_cheque
];
$objClient->Update_Cheque_OutStanding($client_id, $clientData, false);

// 3. Additional Log specifically for General Price change history if needed
include_once("../../../lib/class/class.legal_activitylog_amount.php");
$activity = new LegalActivityLogAmount();
$loggedUserId = $_SESSION['LOGIN_LEGAL_ID'] ?? null;
if ($loggedUserId) {
    $activity->logAmountActivity(
        'Updated Outstanding amounts',
        'legal_activelegal',
        $loggedUserId,
        "Updated Outstanding amounts independently for Active Legal ID: $active_legal_id (Total: $total_outstanding, Cheques: $outstanding_with_cheque, Invoices: $outstanding_without_cheque)",
        $active_legal_id
    );
}

echo json_encode(['success' => true, 'message' => 'Outstanding Amount Updated Successfully']);
