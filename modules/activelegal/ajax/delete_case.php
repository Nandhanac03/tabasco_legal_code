<?php
include_once("../../../lib/config.php");
include_once("../../../lib/class/class.dbcon.php");
session_start();

header('Content-Type: application/json');

$db = new Dbcon();

// Frontend sends 'case_id' which is actually the relation_id
$relation_id = intval($_POST['case_id'] ?? $_POST['relation_id'] ?? 0);

if (!$relation_id) {
    echo json_encode(['success' => false, 'message' => 'Invalid relation ID']);
    exit;
}

// Fetch the relation to get both sides
$relation = $db->SQL_Fetch(
    "SELECT case_id, related_case_id FROM legal_case_relations WHERE id = :id AND status = 'A'",
    ['id' => $relation_id]
);

if (!$relation) {
    echo json_encode(['success' => false, 'message' => 'Relation not found']);
    exit;
}

$a = $relation['case_id'];
$b = $relation['related_case_id'];

// Soft-delete: set status to 'D' for both directions
$db->Query(
    "UPDATE legal_case_relations SET status = 'D' WHERE (case_id = :a AND related_case_id = :b) OR (case_id = :b2 AND related_case_id = :a2)",
    ['a' => $a, 'b' => $b, 'b2' => $b, 'a2' => $a]
);

echo json_encode(['success' => true, 'message' => 'Case relation removed successfully']);
exit;
?>