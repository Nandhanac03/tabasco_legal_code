<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Include config and db class
require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/class/class.dbcon.php";
require_once __DIR__ . "/../lib/class/class.legal_case.php";
require_once __DIR__ . "/../lib/class/class.legal_activitylog_amount.php";
require_once __DIR__ . "/../lib/class/class.legal_activity_log.php";

echo "<h1>Outstanding Save and Log Verification</h1>";

$case_id = 21; // Let's check case 21

$objLegalCase = new LegalCase();
$caseData = $objLegalCase->get_case($case_id);

if (!$caseData) {
    echo "<p style='color: red;'>Error: Case ID $case_id not found in legal_case table.</p>";
    exit;
}

$oldData = $caseData[0];
echo "<h3>Current Case Data (ID: $case_id):</h3>";
echo "<pre>";
print_r([
    'total_outstanding' => $oldData['total_outstanding'],
    'outstanding_with_cheque' => $oldData['outstanding_with_cheque'],
    'outstanding_without_cheque' => $oldData['outstanding_without_cheque'],
    'claim_amount' => $oldData['claim_amount']
]);
echo "</pre>";

// Mock login session if empty
if (!isset($_SESSION['LOGIN_LEGAL_ID'])) {
    $_SESSION['LOGIN_LEGAL_ID'] = 1; // Default to admin/user ID 1 for testing
    echo "<p><i>Notice: LOGIN_LEGAL_ID was not set in session. Mocked to 1.</i></p>";
}

// Generate new mock values
$new_total = floatval($oldData['total_outstanding']) + 10.0;
$new_cheque = floatval($oldData['outstanding_with_cheque']) + 5.0;
$new_without = floatval($oldData['outstanding_without_cheque']) + 5.0;
$new_claim = floatval($oldData['claim_amount']) + 20.0;

echo "<h3>Performing Mock Update:</h3>";
echo "Total: " . $oldData['total_outstanding'] . " -> " . $new_total . "<br>";
echo "PDC: " . $oldData['outstanding_with_cheque'] . " -> " . $new_cheque . "<br>";
echo "Invoices: " . $oldData['outstanding_without_cheque'] . " -> " . $new_without . "<br>";
echo "Claim: " . $oldData['claim_amount'] . " -> " . $new_claim . "<br>";

$sqlCmd = "UPDATE legal_case SET 
    total_outstanding = :total_outstanding, 
    outstanding_with_cheque = :outstanding_with_cheque, 
    outstanding_without_cheque = :outstanding_without_cheque,
    claim_amount = :claim_amount,
    updated_id = :updated_id,
    updated_on = :updated_on
    WHERE id = :id";

$loggedUserId = $_SESSION['LOGIN_LEGAL_ID'];
$params = [
    ':total_outstanding' => $new_total,
    ':outstanding_with_cheque' => $new_cheque,
    ':outstanding_without_cheque' => $new_without,
    ':claim_amount' => $new_claim,
    ':updated_id' => $loggedUserId,
    ':updated_on' => date('Y-m-d H:i:s'),
    ':id' => $case_id
];

$result = $objLegalCase->Query($sqlCmd, $params);

if ($result) {
    echo "<p style='color: green;'>Success: Updated case table.</p>";

    // Logging
    $activity = new LegalActivityLog();
    $actResult = $activity->logActivity(
        'UPDATE',
        'legal_case',
        $loggedUserId,
        "Updated outstanding and claim amounts (TEST MOCK) for Case ID: $case_id",
        $case_id
    );
    echo "General Log Result: " . ($actResult ? "Logged successfully" : "Failed to log") . "<br>";

    $amountActivity = new LegalActivityLogAmount();
    $amtResult = $amountActivity->logAmountActivity(
        'Update Case Outstanding Amount',
        'case',
        $loggedUserId,
        "Case outstanding amounts modified (TEST MOCK): Total ({$oldData['total_outstanding']} -> $new_total), with PDC ({$oldData['outstanding_with_cheque']} -> $new_cheque), with Invoices ({$oldData['outstanding_without_cheque']} -> $new_without), Claimed ({$oldData['claim_amount']} -> $new_claim)",
        $case_id
    );
    echo "Amount Log Result: " . ($amtResult ? "Logged successfully" : "Failed to log") . "<br>";

    // Check newly updated values
    $updatedCaseData = $objLegalCase->get_case($case_id);
    $updatedData = $updatedCaseData[0];
    echo "<h3>Updated Case Data in Database:</h3>";
    echo "<pre>";
    print_r([
        'total_outstanding' => $updatedData['total_outstanding'],
        'outstanding_with_cheque' => $updatedData['outstanding_with_cheque'],
        'outstanding_without_cheque' => $updatedData['outstanding_without_cheque'],
        'claim_amount' => $updatedData['claim_amount']
    ]);
    echo "</pre>";

    // Clean up / revert to old values so we don't mess up their real data permanently
    $paramsRevert = [
        ':total_outstanding' => $oldData['total_outstanding'],
        ':outstanding_with_cheque' => $oldData['outstanding_with_cheque'],
        ':outstanding_without_cheque' => $oldData['outstanding_without_cheque'],
        ':claim_amount' => $oldData['claim_amount'],
        ':updated_id' => $loggedUserId,
        ':updated_on' => date('Y-m-d H:i:s'),
        ':id' => $case_id
    ];
    $objLegalCase->Query($sqlCmd, $paramsRevert);
    echo "<p style='color: blue;'>Notice: Reverted case $case_id back to its original outstanding values.</p>";
} else {
    echo "<p style='color: red;'>Error: Failed to update case table.</p>";
}
?>
