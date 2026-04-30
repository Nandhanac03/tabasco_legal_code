<?php
include_once("../../../lib/config.php");
include_once("../../../lib/class/class.dbcon.php");
include_once("../../../lib/class/class.legal_case.php");

session_start();

$objLegalCase = new LegalCase();
$user_id = $_SESSION['LOGIN_LEGAL_ID'];

if (isset($_POST['case_id'])) {
    $case_id = (int)$_POST['case_id'];
    
    // In this system, "delete" usually means setting status to 'D'
    $Sqlcmd = "UPDATE legal_case SET status = 'D', updated_id = ?, updated_on = ? WHERE id = ?";
    $result = $objLegalCase->Query($Sqlcmd, [$user_id, date('Y-m-d H:i:s'), $case_id]);

    if ($result) {
        // Also update roots
        $objLegalCase->Query("UPDATE legal_case_roots SET status = 'D' WHERE case_id = ?", [$case_id]);
        
        echo json_encode(['success' => true, 'message' => 'Case deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete case']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>
