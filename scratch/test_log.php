<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include necessary files
require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/class/class.dbcon.php";
require_once __DIR__ . "/../lib/class/class.legal_activitylog_amount.php";
require_once __DIR__ . "/../lib/class/class.legal_client.php";
require_once __DIR__ . "/../lib/class/class.legal_active_legals.php";

echo "Database connection check...\n";
$db = new dbcon();

echo "Testing ensureAmountTableExists()...\n";
$amountActivity = new LegalActivityLogAmount();
try {
    $result = $amountActivity->logAmountActivity('Test Action', 'test_module', 1, 'Test outstanding change message', 9999);
    echo "Result of logAmountActivity: " . ($result ? "Success" : "Failure") . "\n";
} catch (Exception $e) {
    echo "Caught exception: " . $e->getMessage() . "\n";
}
