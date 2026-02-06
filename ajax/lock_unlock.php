<?php
header('Content-Type: application/json');
session_start();
error_reporting(0);
ini_set('display_errors', 1);

// Include dependencies
include_once("../lib/config.php");
include_once("../lib/class/class.dbcon.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $locked_status = $_POST['locked_status'] ?? '';
    $moduleIs = $_POST['moduleIs'] ?? '';

    $table_is = '';
    switch ($moduleIs) {
        case 'thirdparty':
            $table_is = 'legal_third_party';
        break;
        case 'legalfirm':
            $table_is = 'legal_firm';
        break;
        case 'debtcollector':
            $table_is = 'legal_debt_collector';
        break;
        // add more cases if needed
    }

    if (!empty($id) && in_array($locked_status, ['Y', 'N']) && !empty($table_is)) {
        try {
            $pdo = new PDO('mysql:host=' . IP . ';dbname=' . DB, USER, DBPWD);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Corrected SQL syntax
            $stmt = $pdo->prepare("UPDATE $table_is SET locked_status = :locked_status WHERE id = :id");

            if ($stmt->execute([':locked_status' => $locked_status, ':id' => $id])) {
                $statusLabel = $locked_status === 'Y' ? 'Locked' : 'Unlocked';
                $_SESSION['PAGE_SUCCESS'] = "The status was updated to $statusLabel";
                echo json_encode([
                    'success' => true,
                    'message' => "The status was updated to: $statusLabel"
                ]);
                exit;
            }

            echo json_encode(['success' => false, 'message' => 'Update failed.']);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'DB Error: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid input or unknown module.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
