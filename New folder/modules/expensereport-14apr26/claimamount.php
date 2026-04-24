<?php
ob_start();
session_start();

/* ------------------ INCLUDE FILES ------------------ */
include_once("lib/config.php");
include_once("lib/class/class.dbcon.php");

include_once("lib/class/class.legal_expense.php");
$objExpense = new Expense();

include_once("lib/class/class.legal_collection.php");
$objCollection = new Collection();

include_once("lib/class/class.legal_active_legals.php");
$objActiveLegal = new ActiveLegal();

include_once("lib/class/class.legal_case.php");
$objLegalCase = new LegalCase();

include_once("lib/class/class.legal_fees_type.php");
$objFees_type = new LegalFees_type();
$fees_types = $objFees_type->get_feesType();

/* ------------------ GET PARAMETERS ------------------ */
$action = isset($_GET['action']) ? $_GET['action'] : '';
$caseid = isset($_GET['param1']) ? (int)$_GET['param1'] : 0;

/* ------------------ GET CASE DETAILS ------------------ */
$legal_case = $objLegalCase->get_case($caseid);

if (!$legal_case) {
    die("❌ Invalid Case");
}

/* ------------------ CLAIM AMOUNT ------------------ */
$claim_amount = (float)$legal_case[0]['claim_amount'];

/* ------------------ ACTIVE LEGAL ------------------ */
$active_legal = $objActiveLegal->Get_ActiveLegal_Information([
    'id' => $legal_case[0]['active_legal_id']
]);

$client_id = $active_legal[0]['client'];
$active_legal_id = $active_legal[0]['id'];
$case_id = $legal_case[0]['id'];

/* ------------------ FILTER ------------------ */
$filter = [
    'client_id' => $client_id,
    'active_legal_id' => $active_legal_id,
    'case_id' => $case_id
];

/* ------------------ GET DATA ------------------ */
$collection = $objCollection->get_collection('', $filter);
$expense    = $objExpense->get_expense('', $filter);

/* ------------------ TOTAL CALCULATION ------------------ */
$total_collection = 0;
if ($collection) {
    foreach ($collection as $rec) {
        $total_collection += (float)$rec['collection_amount'];
    }
}

$total_expense = 0;
if ($expense) {
    foreach ($expense as $rec) {
        $total_expense += (float)$rec['expense_amount'];
    }
}

/* ------------------ TOTAL USED ------------------ */
$total_used = $total_collection + $total_expense;

/* ------------------ REMAINING AMOUNT ------------------ */
$remaining_amount = $claim_amount - $total_used;

/* ------------------ INSERT VALIDATION ------------------ */
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $new_amount = isset($_POST['amount']) ? (float)$_POST['amount'] : 0;

    if ($new_amount <= 0) {
        die("❌ Invalid Amount");
    }

    if (($total_used + $new_amount) > $claim_amount) {
        die("❌ Amount exceeds claim limit");
    }

    // ✅ SAFE TO INSERT HERE
    // Example:
    /*
    $query = "INSERT INTO table_name SET amount = '$new_amount'";
    $db->Query($query);
    */

    echo "✅ Amount Added Successfully";
}

/* ------------------ PASS TO TEMPLATE ------------------ */
$body = "claimamount.tpl";
?>
