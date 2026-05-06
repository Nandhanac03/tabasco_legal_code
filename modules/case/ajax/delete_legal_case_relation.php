<?php
include_once("../../../lib/config.php");
include_once("../../../lib/class/class.dbcon.php");

header('Content-Type: application/json');

$db = new Dbcon();

$relation_id = (int)($_POST['relation_id'] ?? 0);

if ($relation_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid relation ID']);
    exit;
}

$sql = "UPDATE legal_case_to_case_relations SET status = 'D' WHERE id = :id";
$result = $db->Query($sql, ['id' => $relation_id]);

if ($result) {
    echo json_encode(['success' => true, 'message' => 'Relation deleted successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to delete relation']);
}
?>
