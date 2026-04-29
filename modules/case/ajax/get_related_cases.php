<?php
include_once("../../../lib/config.php");
include_once("../../../lib/class/class.dbcon.php");
include_once("../../../lib/class/class.legal_case.php");

$objLegalCase = new LegalCase();

if (isset($_POST['active_legal_id'])) {
    $active_legal_id = (int)$_POST['active_legal_id'];
    $exclude_case_id = isset($_POST['exclude_case_id']) ? (int)$_POST['exclude_case_id'] : 0;
    
    $cases = $objLegalCase->get_case('', $active_legal_id);
    
    $html = '<option value="">-- None (Optional) --</option>';
    if ($cases) {
        foreach ($cases as $case) {
            if ($case['id'] == $exclude_case_id) continue;
            $html .= '<option value="' . $case['id'] . '">' . $case['case_number'] . ' (' . ($case['case_mode_title'] ?? 'N/A') . ')</option>';
        }
    }
    
    echo json_encode(['success' => true, 'html' => $html]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid Request']);
}
?>
