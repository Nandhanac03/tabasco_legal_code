<?php
header('Content-Type: application/json');
error_reporting(0);
ini_set('display_errors', 0);
session_start();

include_once("../../../lib/config.php");
include_once("../../../lib/class/class.dbcon.php");
include_once("../../../lib/class/class.legal_case.php");
include_once("../../../lib/class/class.legal_activitylog_amount.php");
include_once("../../../lib/class/class.legal_activity_log.php");

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode(["status" => "error", "message" => "No data received"]);
    exit;
}

$case_id = isset($data['case_id']) ? (int)$data['case_id'] : 0;
$total_outstanding = isset($data['total_outstanding']) ? (float)$data['total_outstanding'] : 0.0;
$outstanding_with_cheque = isset($data['outstanding_with_cheque']) ? (float)$data['outstanding_with_cheque'] : 0.0;
$outstanding_without_cheque = isset($data['outstanding_without_cheque']) ? (float)$data['outstanding_without_cheque'] : 0.0;
$claim_amount = isset($data['claim_amount']) ? (float)$data['claim_amount'] : 0.0;

if ($case_id <= 0) {
    echo json_encode(["status" => "error", "message" => "Invalid Case ID"]);
    exit;
}

$objLegalCase = new LegalCase();
$caseData = $objLegalCase->get_case($case_id);

if (!$caseData) {
    echo json_encode(["status" => "error", "message" => "Case not found"]);
    exit;
}

$oldData = $caseData[0];

// Execute direct parameterized SQL UPDATE query to save the values in the legal_case table
$sqlCmd = "UPDATE legal_case SET 
    total_outstanding = :total_outstanding, 
    outstanding_with_cheque = :outstanding_with_cheque, 
    outstanding_without_cheque = :outstanding_without_cheque,
    claim_amount = :claim_amount,
    updated_id = :updated_id,
    updated_on = :updated_on
    WHERE id = :id";

$loggedUserId = $_SESSION['LOGIN_LEGAL_ID'] ?? 0;
$params = [
    ':total_outstanding' => $total_outstanding,
    ':outstanding_with_cheque' => $outstanding_with_cheque,
    ':outstanding_without_cheque' => $outstanding_without_cheque,
    ':claim_amount' => $claim_amount,
    ':updated_id' => $loggedUserId,
    ':updated_on' => date('Y-m-d H:i:s'),
    ':id' => $case_id
];

$result = $objLegalCase->Query($sqlCmd, $params);

if ($result) {
    // 1. General Activity Log
    $activity = new LegalActivityLog();
    if ($loggedUserId) {
        $activity->logActivity(
            'UPDATE',
            'legal_case',
            $loggedUserId,
            "Updated outstanding amounts for Case ID: $case_id",
            $case_id
        );
    }

    // 2. Amount Activity Log
    $old_total = (float)($oldData['total_outstanding'] ?? 0);
    $old_cheque = (float)($oldData['outstanding_with_cheque'] ?? 0);
    $old_without = (float)($oldData['outstanding_without_cheque'] ?? 0);
    $old_claim = (float)($oldData['claim_amount'] ?? 0);

    if ($old_total != $total_outstanding || $old_cheque != $outstanding_with_cheque || $old_without != $outstanding_without_cheque || $old_claim != $claim_amount) {
        $amountActivity = new LegalActivityLogAmount();
        $amountActivity->logAmountActivity(
            'Update Case Outstanding Amount',
            'case',
            $loggedUserId,
            "Case outstanding amounts modified: Total ($old_total -> $total_outstanding), with PDC ($old_cheque -> $outstanding_with_cheque), with Invoices ($old_without -> $outstanding_without_cheque), Claimed ($old_claim -> $claim_amount)",
            $case_id
        );
    }

    echo json_encode([
        "status" => "success",
        "message" => "Outstanding amount saved successfully",
        "total_outstanding" => $total_outstanding,
        "outstanding_with_cheque" => $outstanding_with_cheque,
        "outstanding_without_cheque" => $outstanding_without_cheque,
        "claim_amount" => $claim_amount
    ]);
    exit;
} else {
    echo json_encode(["status" => "error", "message" => "Failed to update amounts in database"]);
    exit;
}
?>
