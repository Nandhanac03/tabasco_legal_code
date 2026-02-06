<?php
header('Content-Type: application/json');
error_reporting(0);
ini_set('display_errors', 1);
session_start();

include_once("../lib/config.php");
include_once("../lib/class/class.dbcon.php");
include_once("../lib/class/class.legal_case.php");
include_once("../lib/class/class.legal_document.php");

$objprocessDocument = new processDocument();
$objLegalCase = new LegalCase();

$parent_id   = $_REQUEST['parent_id'] ?? null;
$list_module = $_REQUEST['list_module'] ?? null;
$list_page   = $_REQUEST['list_page'] ?? null;
$alphabet    = $_REQUEST['alphabet'] ?? null;

/* Module → Parent Type */
switch ($list_module) {
    case 'legalfirm':
        $parent_type = 'LF';
        break;
    case 'client':
        $parent_type = 'C';
        break;
    case 'thirdparty':
        $parent_type = 'TP';
        break;
    case 'activelegal':
        $parent_type = 'AL';
        break;
    case 'case':
        $parent_type = 'CA';
        break;
    default:
        $parent_type = '';
        break;
}

if (!$parent_id || !$alphabet) {
    echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
    exit;
}

/* Get client ID if module is case */
$client_id = null;
if ($list_module === 'case') {
    $case = $objLegalCase->get_case_info($parent_id);
    $client_id = $case[0]['client_id'] ?? null;
}

/* ================= LIST ================= */
if ($alphabet === 'list') {

    $case_docs = $objprocessDocument->get_document('', $parent_id, $parent_type);
    $case_docs = is_array($case_docs) ? $case_docs : [];

    $client_docs = [];
    if ($client_id) {
        $client_docs = $objprocessDocument->get_document('', $client_id, 'C');
        $client_docs = is_array($client_docs) ? $client_docs : [];
    }

    echo json_encode([
        'success' => true,
        'data' => [
            'case_docs'   => $case_docs,
            'client_docs' => $client_docs
        ]
    ]);
    exit;
}

/* ================= DELETE ================= */
if ($alphabet === 'delete') {

    $id = intval($_REQUEST['id'] ?? 0);
    if ($id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid ID']);
        exit;
    }

    $doc = $objprocessDocument->get_document($id)[0] ?? null;
    if (!$doc) {
        echo json_encode(['success' => false, 'message' => 'Document not found']);
        exit;
    }

    /* 🚫 Block client document deletion */
    if ($doc['parent_type'] === 'C') {
        echo json_encode([
            'success' => false,
            'message' => 'Client documents cannot be deleted'
        ]);
        exit;
    }

    $update = [
        'id'        => $id,
        'status'    => 'D',
        'update_by' => $_SESSION['LOGIN_LEGAL_ID'],
        'update_on' => date('Y-m-d H:i:s')
    ];

    $file = '../uploads/all_document/' . $doc['name'];

    if ($objprocessDocument->Delete_document($id, $update)) {
        if (file_exists($file)) unlink($file);
        echo json_encode(['success' => true, 'message' => 'Deleted']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Delete failed']);
    }
    exit;
}
