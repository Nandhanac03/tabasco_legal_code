<?php
session_start();
include_once("../../../lib/config.php");
include_once("../../../lib/class/class.dbcon.php");

header('Content-Type: application/json');

$db = new Dbcon();

$main_case_id = (int)($_POST['main_case_id'] ?? 0);
$related_case_id = (int)($_POST['related_case_id'] ?? 0);
$user_id = $_SESSION['LOGIN_LEGAL_ID'] ?? 0;

if ($main_case_id <= 0 || $related_case_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid case IDs']);
    exit;
}

if ($main_case_id === $related_case_id) {
    echo json_encode(['success' => false, 'message' => 'Cannot link a case to itself']);
    exit;
}

// Check if already linked
$sql_check = "
    SELECT id FROM legal_case_to_case_relations 
    WHERE status = 'A' 
      AND (
          (main_case_id = :id1 AND related_case_id = :id2)
       OR (main_case_id = :id3 AND related_case_id = :id4)
      )
";
$check = $db->SELECT_MultiFetch($sql_check, [
    'id1' => $main_case_id,
    'id2' => $related_case_id,
    'id3' => $related_case_id,
    'id4' => $main_case_id
]);

if (!empty($check)) {
    echo json_encode(['success' => false, 'message' => 'These cases are already linked']);
    exit;
}

$sql_insert = "
    INSERT INTO legal_case_to_case_relations (main_case_id, related_case_id, created_by, created_on, status) 
    VALUES (:main_case_id, :related_case_id, :created_by, NOW(), 'A')
";
$result = $db->Query($sql_insert, [
    'main_case_id' => $main_case_id,
    'related_case_id' => $related_case_id,
    'created_by' => $user_id
]);

if ($result) {
    echo json_encode(['success' => true, 'message' => 'Relation created successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to create relation']);
}
?>
