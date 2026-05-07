<?php
include_once("../../../lib/config.php");
include_once("../../../lib/class/class.dbcon.php");
include_once("../../../lib/class/class.legal_case.php");

session_start();
header('Content-Type: application/json');

$objLegalCase = new LegalCase();
$user_id = $_SESSION['LOGIN_LEGAL_ID'] ?? 0;

$case_id = $_POST['case_id'] ?? '';
$related_ids = $_POST['related_case_ids'] ?? [];

if (!$case_id) {
    echo json_encode([
        'success' => false,
        'message' => 'Missing case_id'
    ]);
    exit;
}

if (empty($related_ids)) {
    echo json_encode([
        'success' => false,
        'message' => 'No related cases selected'
    ]);
    exit;
}

try {

    foreach ($related_ids as $rid) {

        if (!$rid || $rid == $case_id) continue;

        $result = $objLegalCase->saveCaseRelation(
            $case_id,
            $rid,
            $user_id
        );

        if (!$result) {
            throw new Exception("Insert failed for ID: " . $rid);
        }
    }

    echo json_encode([
        'success' => true,
        'message' => 'Saved successfully'
    ]);

} catch (Exception $e) {

    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
