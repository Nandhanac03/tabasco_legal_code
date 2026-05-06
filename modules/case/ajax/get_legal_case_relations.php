<?php
include_once("../../../lib/config.php");
include_once("../../../lib/class/class.dbcon.php");

header('Content-Type: application/json');

$db = new Dbcon();

$main_case_id = (int)($_GET['main_case_id'] ?? 0);

if ($main_case_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'No main_case_id provided']);
    exit;
}

$sql = "
    SELECT 
        r.id AS relation_id,
        r.created_on,
        u.user_name AS creator_name,
        lc.case_number AS related_case_number,
        cli.name AS related_client_name
    FROM legal_case_to_case_relations r
    LEFT JOIN legal_case lc ON (
        IF(r.main_case_id = :id1, r.related_case_id, r.main_case_id) = lc.id
    )
    LEFT JOIN legal_activelegal al ON lc.active_legal_id = al.id
    LEFT JOIN legal_client cli ON al.client = cli.id
    LEFT JOIN users u ON r.created_by = u.user_Id
    WHERE r.status = 'A'
      AND (r.main_case_id = :id2 OR r.related_case_id = :id3)
    ORDER BY r.id DESC
";

$relations = $db->SELECT_MultiFetch($sql, [
    'id1' => $main_case_id,
    'id2' => $main_case_id,
    'id3' => $main_case_id
]);

echo json_encode([
    'success' => true,
    'data' => $relations ?: []
]);
?>
