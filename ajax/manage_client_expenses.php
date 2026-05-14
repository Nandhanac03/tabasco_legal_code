<?php
header('Content-Type: application/json');
error_reporting(0);
ini_set('display_errors', 0);
session_start();

include_once("../lib/config.php");
include_once("../lib/class/class.dbcon.php");
include_once("../lib/class/class.legal_expense.php");
include_once("../lib/class/class.legal_fees_type.php");

$objExpense = new Expense();
$objFeesType = new LegalFees_type();

$data = json_decode(file_get_contents("php://input"), true);
$action = $data['action'] ?? $_POST['action'] ?? $_GET['action'] ?? '';

if (!$action) {
    echo json_encode(["status" => "error", "message" => "No action specified"]);
    exit;
}

// Function to get or create fee type ID by title
function getFeeTypeId($objFeesType, $title) {
    $existing = $objFeesType->get_feesType('', $title);
    if ($existing) {
        return $existing[0]['id'];
    }
    
    $saveData = [
        'title' => $title,
        'status' => 'A',
        'created_by' => $_SESSION['LOGIN_LEGAL_ID'] ?? 0,
        'created_on' => date('Y-m-d H:i:s'),
        'updated_by' => $_SESSION['LOGIN_LEGAL_ID'] ?? 0,
        'updated_on' => date('Y-m-d H:i:s')
    ];
    $objFeesType->save_feesType($saveData);
    return $objFeesType->mysqlInsertid();
}

switch ($action) {
    case 'add_expense':
        $clientId = $data['client_id'] ?? null;
        $activeLegalId = $data['active_legal_id'] ?? null;
        $feeTitle = $data['fee_title'];
        $amount = (float)($data['amount'] ?? 0);
        $remark = $data['remark'] ?? '';
        
        if ((!$clientId && !$activeLegalId) || !$feeTitle || $amount <= 0) {
            echo json_encode(["status" => "error", "message" => "Missing required fields"]);
            exit;
        }
        
        $feeTypeId = getFeeTypeId($objFeesType, $feeTitle);
        
        $expenseData = [
            'fees_type' => $feeTypeId,
            'amount' => $amount,
            'date' => date('Y-m-d'),
            'description' => $feeTitle . ($remark ? " - " . $remark : ""),
            'remark' => $remark,
            'status' => 'A',
            'created_by' => $_SESSION['LOGIN_LEGAL_ID'] ?? 0,
            'created_on' => date('Y-m-d H:i:s')
        ];

        if ($clientId) $expenseData['client_id'] = $clientId;
        if ($activeLegalId) $expenseData['active_legal_id'] = $activeLegalId;
        
        if ($objExpense->save_expense($expenseData)) {
            echo json_encode(["status" => "success", "message" => "Expense added successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to add expense"]);
        }
        break;

    case 'get_expenses':
        $clientId = $data['client_id'] ?? $_GET['client_id'] ?? '';
        $activeLegalId = $data['active_legal_id'] ?? $_GET['active_legal_id'] ?? '';

        if (!$clientId && !$activeLegalId) {
            echo json_encode(["status" => "error", "message" => "Client ID or Active Legal ID missing"]);
            exit;
        }
        
        $filters = [];
        if ($clientId) $filters['client_id'] = $clientId;
        if ($activeLegalId) $filters['active_legal_id'] = $activeLegalId;

        $expenses = $objExpense->get_expense('', $filters);
        echo json_encode(["status" => "success", "data" => $expenses ?: []]);
        break;

    case 'delete_expense':
        $expenseId = $data['expense_id'];
        if (!$expenseId) {
            echo json_encode(["status" => "error", "message" => "Expense ID missing"]);
            exit;
        }
        
        $updateData = [
            'status' => 'D',
            'updated_by' => $_SESSION['LOGIN_LEGAL_ID'] ?? 0,
            'updated_on' => date('Y-m-d H:i:s')
        ];
        
        // Using the delete_hearing method which is actually for legal_expense status update
        if ($objExpense->delete_hearing($updateData, $expenseId)) {
            echo json_encode(["status" => "success", "message" => "Expense deleted successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to delete expense"]);
        }
        break;
}
?>
