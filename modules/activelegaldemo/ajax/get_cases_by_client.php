<?php
include_once("../../../lib/config.php");
include_once("../../../lib/class/class.dbcon.php");

header('Content-Type: application/json');

$db = new Dbcon();

$client_id       = isset($_GET['client_id'])       ? (int)$_GET['client_id']       : 0;
$current_case_id = isset($_GET['current_case_id']) ? (int)$_GET['current_case_id'] : 0;
$exclude_id      = isset($_GET['exclude_id'])      ? (int)$_GET['exclude_id']      : 0;

if (!$client_id) {
    echo json_encode(['success' => false, 'data' => []]);
    exit;
}

// Fetch other active legals for the same client
// Exclude both the selected case AND the current page's active legal
$sql = "
    SELECT al.id, al.code AS case_number
    FROM legal_activelegal AS al
    WHERE al.client = :client_id
      AND al.id != :current_case_id
      AND al.id != :exclude_id
      AND al.status = 'A'
    ORDER BY al.id DESC
";

$data = $db->SELECT_MultiFetch($sql, [
    'client_id'       => $client_id,
    'current_case_id' => $current_case_id,
    'exclude_id'      => $exclude_id ?: 0
]);

echo json_encode([
    'success' => true,
    'data'    => $data ?: []
]);
