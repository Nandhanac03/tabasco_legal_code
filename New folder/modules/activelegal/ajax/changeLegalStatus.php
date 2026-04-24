<?php

ob_start();
session_start();
error_reporting(0);

include_once("../../../lib/config.php");
include_once("../../../lib/class/class.dbcon.php");
include_once("../../../lib/class/class.legal_active_legals.php");

$objActiveLegal = new ActiveLegal();

include_once("../../../lib/auth_ajax.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'change_status') {
    // Debug incoming request

    $id = (int)$_POST['id'];
    $input_data = [];
    $input_data['legal_status'] = $_POST['newStatus'];
    $input_data['legal_status_reason'] = $_POST['legalreson'];
    $success = $objActiveLegal->Manage_ActiveLegal($input_data, $id);
    header('Content-Type: application/json');
    if ($success) {
        echo json_encode(['success' => true, 'message' => 'Status updated']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Update failed']);
    }
    exit;
}
