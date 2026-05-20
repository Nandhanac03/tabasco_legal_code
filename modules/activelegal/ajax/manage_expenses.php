<?php
session_start();
include_once("../../../lib/config.php");
include_once("../../../lib/class/class.dbcon.php");
include_once("../../../lib/class/class.legal_expense.php");


$objExpense = new Expense();

$action = $_POST['action'] ?? '';
$active_legal_id = $_POST['active_legal_id'] ?? '';

$response = ['success' => false, 'message' => 'Invalid action'];

if ($action == 'add') {
    $fee_type = $_POST['fee_type'] ?? '';
    $amount = $_POST['amount'] ?? '';
    $reason = $_POST['reason'] ?? '';
    
    if (empty($active_legal_id) || empty($fee_type) || empty($amount)) {
        echo json_encode(['success' => false, 'message' => 'Missing required fields']);
        exit;
    }
    
    $data = [
        'active_legal_id' => $active_legal_id,
        'fees_type' => $fee_type,
        'amount' => $amount,
        'description' => $reason,
        'date' => date('Y-m-d'),
        'created_on' => date('Y-m-d H:i:s'),
        'created_by' => $_SESSION['LOGIN_LEGAL_ID'],
        'status' => 'A'
    ];
    
    if ($objExpense->save_expense($data)) {
        $response = ['success' => true, 'message' => 'Expense added successfully'];
    } else {
        $response = ['success' => false, 'message' => 'Failed to add expense'];
    }
} elseif ($action == 'delete') {
    $id = $_POST['id'] ?? '';
    if (empty($id)) {
        echo json_encode(['success' => false, 'message' => 'Missing expense ID']);
        exit;
    }
    
    $data = [
        'status' => 'D',
        'updated_by' => $_SESSION['LOGIN_LEGAL_ID'],
        'updated_on' => date('Y-m-d H:i:s')
    ];
    
    if ($objExpense->delete_hearing($data, $id)) {
        $response = ['success' => true, 'message' => 'Expense deleted successfully'];
    } else {
        $response = ['success' => false, 'message' => 'Failed to delete expense'];
    }
} elseif ($action == 'list') {
    $expenses = $objExpense->get_expense('', ['status' => 'A', 'active_legal_id' => $active_legal_id]);
    
    $html = '';
    $total = 0;
    
    if ($expenses && is_array($expenses)) {
        foreach ($expenses as $row) {
            $title = !empty($row['fees_type_title']) ? htmlspecialchars($row['fees_type_title']) : 'Other';
            if (!empty($row['description'])) {
                $title .= ' - ' . htmlspecialchars($row['description']);
            }
            $amount = (float) $row['amount'];
            $total += $amount;
            
            $html .= '<tr>';
            $html .= '<td>' . $title . '</td>';
            $html .= '<td class="text-end">' . number_format($amount, 2) . '</td>';
            $html .= '<td class="text-center">';
            $html .= '<button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteClientExpense(' . $row['id'] . ', \'' . $active_legal_id . '\')"><i class="bx bx-trash"></i></button>';
            $html .= '</td>';
            $html .= '</tr>';
        }
    } else {
        $html = '<tr><td colspan="3" class="text-center text-muted">No expenses found</td></tr>';
    }
    
    $response = [
        'success' => true,
        'html' => $html,
        'total_sum' => number_format($total, 2, '.', '')
    ];
}

echo json_encode($response);
