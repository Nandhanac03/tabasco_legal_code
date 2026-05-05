<?php
include_once("../../../lib/config.php");
include_once("../../../lib/class/class.dbcon.php");

header('Content-Type: application/json');

$db = new Dbcon();

if (!isset($_GET['active_legal_id']) || empty($_GET['active_legal_id'])) {
    echo json_encode(['success' => false, 'message' => 'No active_legal_id provided']);
    exit;
}

$active_legal_id = (int)$_GET['active_legal_id'];

$sql = "
    SELECT 
        r.id           AS relation_id,
        r.case_id,
        r.related_case_id,
        r.created_on,

        al_main.code   AS main_code,
        cli_main.name  AS main_client_name,

        al_rel.code    AS related_code,
        cli_rel.name   AS related_client_name,

        usr.user_name  AS creator_name,

        lc_main.case_number  AS main_case_number,
        lc_rel.case_number   AS related_case_number

    FROM legal_case_relations AS r

    LEFT JOIN legal_activelegal AS al_main  ON r.case_id = al_main.id
    LEFT JOIN legal_client      AS cli_main ON al_main.client = cli_main.id

    LEFT JOIN legal_activelegal AS al_rel   ON r.related_case_id = al_rel.id
    LEFT JOIN legal_client      AS cli_rel  ON al_rel.client = cli_rel.id

    LEFT JOIN users             AS usr      ON r.created_by = usr.user_Id

    LEFT JOIN legal_case AS lc_main ON lc_main.id = (
        SELECT id FROM legal_case 
        WHERE active_legal_id = r.case_id AND status = 'A' 
        ORDER BY id DESC LIMIT 1
    )

    LEFT JOIN legal_case AS lc_rel ON lc_rel.id = (
        SELECT id FROM legal_case 
        WHERE active_legal_id = r.related_case_id AND status = 'A' 
        ORDER BY id DESC LIMIT 1
    )

    WHERE r.status = 'A'
      AND (r.case_id = :id1 OR r.related_case_id = :id2)

    ORDER BY r.id DESC
";

$cases = $db->SELECT_MultiFetch($sql, [
    'id1' => $active_legal_id,
    'id2' => $active_legal_id
]);

echo json_encode([
    'success' => true,
    'data'    => $cases ?: [],
    'active_legal_id' => $active_legal_id
]);
?>
