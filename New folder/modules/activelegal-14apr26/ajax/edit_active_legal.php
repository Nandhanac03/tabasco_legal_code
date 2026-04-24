<?php

ob_start();
session_start();
error_reporting(0);

include_once("../../../lib/config.php");
include_once("../../../lib/class/class.dbcon.php");
include_once("../../../lib/class/class.legal_active_legals.php");
$objActiveLegal = new ActiveLegal();

if($_POST){
    $edit_id = trim($_POST['edit_ID'] ?? 0);

    $filters = array();
    $filters['status'] = 'A';
    $filters['id'] = $edit_id;
    $array_active_legal_data = array();
    if ($edit_id > 0)
        $data = $objActiveLegal->Get_ActiveLegal_Information($filters)[0];

        echo '<pre>';
        print_r($data);
        exit;
    echo json_encode([
        'success' => true,
        'data' => $data
    ]);
    exit;
}