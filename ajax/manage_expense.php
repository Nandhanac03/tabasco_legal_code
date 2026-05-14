<?php
header('Content-Type: application/json');
session_start();
error_reporting(0);

include_once("../lib/config.php");
include_once("../lib/class/class.dbcon.php");
include_once("../lib/class/class.legal_expense.php");
include_once("../lib/class/class.legal_fees_type.php");
include_once("../lib/class/class.legal_client.php");

$objExpense = new Expense();
$objFeesType = new LegalFees_type();
$objClients = new Clients();

$action = $_POST['action'] ?? '';

switch ($action) {
    case 'save':
        $parent_id = $_POST['parent_id'];
        $module = $_POST['module'];
        $fees_type_str = $_POST['fees_type'];
        $other_reason = $_POST['other_reason'] ?? '';
        $amount = (float)($_POST['amount'] ?? 0);
        $date = $_POST['expense_date'];
        
        if (!$parent_id || !$fees_type_str || $amount <= 0) {
            echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
            exit;
        }

        // 1. Get or Create Fee Type ID
        $fee_type_title = ($fees_type_str === 'Other' && !empty($other_reason)) ? $other_reason : $fees_type_str;
        
        $existing_type = $objFeesType->get_feesType('', $fee_type_title);
        if ($existing_type) {
            $fee_type_id = $existing_type[0]['id'];
        } else {
            // Create new fee type
            $type_data = [
                'title' => $fee_type_title,
                'status' => 'A',
                'created_by' => $_SESSION['LOGIN_LEGAL_ID'] ?? 0,
                'created_on' => date('Y-m-d H:i:s'),
                'updated_by' => $_SESSION['LOGIN_LEGAL_ID'] ?? 0,
                'updated_on' => date('Y-m-d H:i:s')
            ];
            $objFeesType->save_feesType($type_data);
            $fee_type_id = $objFeesType->mysqlInsertid();
        }

        // 2. Map IDs based on module
        $client_id = 0;
        $active_legal_id = 0;
        $marketing_id = 0;

        if ($module === 'clientdemo') {
            $client_id = $parent_id;
            $client_info = $objClients->Get_Client_Information($client_id)[0] ?? [];
            $marketing_id = $client_info['marketing'] ?? 0;
        } elseif ($module === 'activelegal') {
            $active_legal_id = $parent_id;
            include_once("../lib/class/class.legal_active_legals.php");
            $objActiveLegal = new ActiveLegal();
            $al_info = $objActiveLegal->Get_ActiveLegal_Information(['id' => $active_legal_id])[0] ?? [];
            $client_id = $al_info['client'] ?? 0;
            $marketing_id = $al_info['user_id'] ?? 0;
        }

        // 3. Handle Attachment
        $document = '';
        if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = "../uploads/expenses/";
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
            
            $fileName = time() . '_' . basename($_FILES['attachment']['name']);
            $targetFile = $uploadDir . $fileName;
            
            if (move_uploaded_file($_FILES['attachment']['tmp_name'], $targetFile)) {
                $document = $fileName;
            }
        }

        // 4. Save Expense
        $expense_data = [
            'client_id' => $client_id,
            'active_legal_id' => $active_legal_id,
            'marketing_id' => $marketing_id,
            'fees_type' => $fee_type_id,
            'amount' => $amount,
            'date' => $date,
            'description' => ($fees_type_str === 'Other' ? $other_reason : ''),
            'document' => $document,
            'status' => 'A',
            'created_by' => $_SESSION['LOGIN_LEGAL_ID'] ?? 0,
            'created_on' => date('Y-m-d H:i:s')
        ];

        $res = $objExpense->save_expense($expense_data);
        if ($res) {
            echo json_encode(['success' => true, 'message' => 'Expense added successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error while saving expense.']);
        }
        break;

    case 'list':
        $parent_id = $_POST['parent_id'];
        $module = $_POST['module'];
        if (!$parent_id) {
            echo json_encode(['success' => false, 'message' => 'Parent ID missing.']);
            exit;
        }

        $filters = ['status' => 'A'];
        if ($module === 'clientdemo') {
            $filters['client_id'] = $parent_id;
        } elseif ($module === 'activelegal') {
            $filters['active_legal_id'] = $parent_id;
        }

        $expenses = $objExpense->get_expense('', $filters);
        
        echo json_encode(['success' => true, 'data' => $expenses ? $expenses : []]);
        break;

    case 'delete':
        $id = $_POST['id'];
        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'ID missing.']);
            exit;
        }

        $data = [
            'status' => 'D',
            'updated_by' => $_SESSION['LOGIN_LEGAL_ID'] ?? 0,
            'updated_on' => date('Y-m-d H:i:s')
        ];
        $res = $objExpense->delete_hearing($data, $id); // reuse delete_hearing method which is a generic soft delete
        if ($res) {
            echo json_encode(['success' => true, 'message' => 'Expense deleted.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error deleting expense.']);
        }
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action.']);
        break;
}
