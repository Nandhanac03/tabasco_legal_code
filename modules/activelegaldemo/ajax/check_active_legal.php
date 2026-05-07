<?php

ob_start();
session_start();
error_reporting(0);

include_once("../../../lib/config.php");
include_once("../../../lib/class/class.dbcon.php");
include_once("../../../lib/class/class.legal_active_legals.php");
$objActiveLegal = new ActiveLegal();



if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'is_unique' => false,
        'message' => 'No data received'
    ]);
    exit;
}

if ($_POST['which_type_user'] == 'marketing') {

    $user_id = $_POST['select_marketing'] ?? null;
    $client  = $_POST['selectedClientId'] ?? null;
} else {
    $user_id = $_POST['select_internal'] ?? null;
    $client  = $_POST['select_Internalclient'] ?? null;
}
$edit_id = $_POST['edit_ID'] ?? null;



if (!empty($edit_id)) {
    echo json_encode([
        'is_unique' => true
    ]);
    exit;
}

if (!$user_id || !$client) {
    echo json_encode([
        'is_unique' => false,
        'message' => 'Invalid data'
    ]);
    exit;
}

$is_unique = $objActiveLegal->Get_ActiveLegal_Information([
    'user_id' => $user_id,
    'client'  => $client
]);

if (count($is_unique) > 0) {
    echo json_encode([
        'is_unique' => false,
        'message' => 'The selected Marketing and Client combination already exists. Please choose a different combination.'
    ]);
    exit;
}


echo json_encode([
    'is_unique' => true
]);
exit;
