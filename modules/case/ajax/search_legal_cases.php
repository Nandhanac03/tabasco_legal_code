<?php
include_once("../../../lib/config.php");
include_once("../../../lib/class/class.dbcon.php");

header('Content-Type: application/json');

$db = new Dbcon();

$keyword = trim($_GET['keyword'] ?? '');
$exclude_id = (int)($_GET['exclude_id'] ?? 0);

if (strlen($keyword) < 2) {
    echo json_encode(['success' => false, 'data' => []]);
    exit;
}

$sql = "
    SELECT 
        lc.id, 
        lc.case_number, 
        cli.name AS client_name
    FROM legal_case lc
    LEFT JOIN legal_activelegal al ON lc.active_legal_id = al.id
    LEFT JOIN legal_client cli ON al.client = cli.id
    WHERE lc.status = 'A'
      AND lc.case_number LIKE :keyword
";

$params = ['keyword' => '%' . $keyword . '%'];

if ($exclude_id > 0) {
    $sql .= " AND lc.id != :exclude_id";
    $params['exclude_id'] = $exclude_id;
}

$sql .= " ORDER BY lc.id DESC LIMIT 50";

$cases = $db->SELECT_MultiFetch($sql, $params);

echo json_encode([
    'success' => true,
    'data' => $cases ?: []
]);
?>
