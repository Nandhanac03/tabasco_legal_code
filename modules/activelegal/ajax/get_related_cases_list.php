<?php
include_once("../../../lib/config.php");
include_once("../../../lib/class/class.dbcon.php");

$db = new Dbcon();

if (isset($_GET['active_legal_id'])) {
    $active_legal_id = (int)$_GET['active_legal_id'];
    
    // Find the client_id for the given active_legal_id
    $client_info = $db->SQL_Fetch("SELECT client FROM legal_activelegal WHERE id = ?", [$active_legal_id]);
    $client_id = isset($client_info['client']) ? (int)$client_info['client'] : 0;
    
    if ($client_id > 0) {
        // Fetch all cases for this client with more details using LEFT JOINs
        $Sqlcmd = "
            SELECT 
                lc.id, 
                lc.case_number, 
                lc.register_date, 
                lcm.title AS case_mode_title, 
                al.code AS active_legal_code,
                cli.name AS client_name,
                usr.user_name AS creator_name,
                rel.case_number AS related_case_number
            FROM legal_case AS lc
            LEFT JOIN legal_case_mode AS lcm ON lc.case_mode = lcm.id
            LEFT JOIN legal_activelegal AS al ON lc.active_legal_id = al.id
            LEFT JOIN legal_client AS cli ON al.client = cli.id
            LEFT JOIN users AS usr ON lc.created_id = usr.user_Id
            LEFT JOIN legal_case AS rel ON lc.related_case_id = rel.id
            WHERE al.client = ? AND lc.status = 'A'
            ORDER BY lc.id DESC
        ";
        $cases = $db->SELECT_MultiFetch($Sqlcmd, [$client_id]);
        
        echo json_encode([
            'success' => true, 
            'data' => $cases ?: [],
            'client_id' => $client_id,
            'active_legal_id' => $active_legal_id
        ]);
    } else {
        echo json_encode([
            'success' => false, 
            'message' => 'Client not found for Active Legal ID: ' . $active_legal_id,
            'active_legal_id' => $active_legal_id
        ]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No active_legal_id provided']);
}
?>
