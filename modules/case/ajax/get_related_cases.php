<?php
include_once("../../../lib/config.php");
include_once("../../../lib/class/class.dbcon.php");
include_once("../../../lib/class/class.legal_case.php");

$objLegalCase = new LegalCase();

if (isset($_POST['active_legal_id'])) {
    $active_legal_id = (int)$_POST['active_legal_id'];
    $exclude_case_id = isset($_POST['exclude_case_id']) ? (int)$_POST['exclude_case_id'] : 0;
    
    // Find the client_id for the given active_legal_id
    $client_info = $objLegalCase->SQL_Fetch("SELECT client FROM legal_activelegal WHERE id = ?", [$active_legal_id]);
    $client_id = $client_info['client'] ?? 0;
    
    if ($client_id > 0) {
        // Fetch all active_legal_ids for this client
        $active_legals = $objLegalCase->SELECT_MultiFetch("SELECT id FROM legal_activelegal WHERE client = ? AND status = 'A'", [$client_id]);
        $al_ids = array_column($active_legals, 'id');
        
        $html = '<option value="">-- None (Optional) --</option>';
        if (!empty($al_ids)) {
            $placeholders = implode(',', array_fill(0, count($al_ids), '?'));
            $Sqlcmd = "
                SELECT lc.*, lcm.title AS case_mode_title
                FROM legal_case AS lc
                JOIN legal_case_mode AS lcm ON lc.case_mode = lcm.id
                WHERE lc.active_legal_id IN ($placeholders) AND lc.status = 'A'
                ORDER BY lc.id DESC
            ";
            $cases = $objLegalCase->SELECT_MultiFetch($Sqlcmd, $al_ids);
            
            if ($cases) {
                foreach ($cases as $case) {
                    if ($case['id'] == $exclude_case_id) continue;
                    $html .= '<option value="' . $case['id'] . '">' . $case['case_number'] . ' (' . ($case['case_mode_title'] ?? 'N/A') . ')</option>';
                }
            }
        }
        echo json_encode(['success' => true, 'html' => $html]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Client not found']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid Request']);
}
?>
