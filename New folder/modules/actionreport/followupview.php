<?php
ob_start();
session_start();
# including files here

$rootPath = dirname(dirname(__DIR__));

include_once($rootPath . "/lib/config.php");
include_once($rootPath . "/lib/class/class.dbcon.php");
include_once($rootPath . "/lib/class/class.legal_active_legals.php");
include_once($rootPath . "/lib/class/class.legal_case.php");
include_once($rootPath . "/lib/class/class.legal_third_party.php");
include_once($rootPath . "/lib/class/class.legal_debt_collector.php");
include_once($rootPath . "/lib/class/class.legal_firm.php");
include_once($rootPath . "/lib/class/class.legal_category.php");
include_once($rootPath . "/lib/class/class.legal_action_subcategory.php");
include_once($rootPath . "/lib/class/class.legal_case_root_actions.php");
include_once($rootPath . "/lib/class/class.legal_temp_case.php");

$objTempLegalCase = new LegalTempCase();
$objActiveLegal = new ActiveLegal();
$objLegalCase = new LegalCase();
$objThirdParty = new thirdParty();
$objDebtCollector = new DebtCollector();
$objLegalFirm = new LegalFirm();
$objLegalCategory = new Category();
$objLegalSubCategory = new ActionSubcategory();
$objcaseRootAction = new CaseRootAction();
$action = $_GET['action'];
$id = $_GET['param1']; // caseid


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'new_followaction') {
    // echo '<pre>';
    // print_r($_FILES);


    $data = [];
    if (!empty($_FILES['document_file']['name']) && $_FILES['document_file']['error'] === 0) {
        $allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
        $maxSize = 1 * 1024 * 1024; // 1MB
        $fileTmp  = $_FILES['document_file']['tmp_name'];
        $fileName = basename($_FILES['document_file']['name']);
        $fileSize = $_FILES['document_file']['size'];
        $fileType = mime_content_type($fileTmp);

        if (!in_array($fileType, $allowedTypes)) {
            echo json_encode(['success' => false, 'message' => 'Invalid file type.']);
            exit;
        }
        if ($fileSize > $maxSize) {
            echo json_encode(['success' => false, 'message' => 'File size exceeds 1MB.']);
            exit;
        }

        // ✅ Ensure upload directory exists
        $uploadDir = $rootPath . '/uploads/action_documents/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // ✅ Generate unique filename
        $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
        $uniqueFileName = uniqid('doc_', true) . '.' . $fileExt;

        $targetPath = $uploadDir . $uniqueFileName;

        // ✅ Move file
        if (move_uploaded_file($fileTmp, $targetPath)) {
            $data['document'] = $uniqueFileName;
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to upload file.']);
            exit;
        }
    }

    // ✅ Handle form data
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'new_followaction') {
        $data['active_legal_id'] = $_POST['active_legal_id'] ?? null;
        $data['date'] = $_POST['date'] ?? null;
        $data['description'] = $_POST['description'] ?? null;
        $data['created_by'] = $_SESSION['LOGIN_LEGAL_ID'] ?? null;
        $data['created_from'] = 'FA';
        $data['case_id'] = $_POST['case_id'] ?? null;
        $data['category_id'] = $_POST['category_id'] ?? null;
        $data['action_subcategory_id'] = $_POST['sub_category_id'] ?? null;
        $data['case_root_id'] = $_POST['stage'] ?? null;
        $data['uae_pass'] = $_POST['uae_pass'] ?? null;
        $data['client_id'] = $_POST['client_id'] ?? null;
        $data['firm_id'] = $_POST['firm_id'] ?? null;
        $data['parent_type'] = $_POST['parent_type'] ?? null;
        $data['case_type'] = $_POST['case_type'] ?? null;

        $success = $objcaseRootAction->save_case_root($data);
        if ($success) {
            echo json_encode(['success' => true, 'message' => 'New Action Added']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Something went wrong']);
        }
        exit;
    }
}

if (!$action || !$id) {
    header("location: " . ROOT_DIR . "actionreport/followupactions.html");
    exit;
}

switch ($action) {

    case 'view':

        $legal_precase = $objTempLegalCase->getTempCase(['id' => $id]);
        if ($legal_precase) {
            $active_legal_id = $legal_precase[0]['active_legal_id'];
        }

        $active_legal = $objActiveLegal->Get_ActiveLegal_Information(['id' => $active_legal_id]);

        $all_category = $objLegalCategory->get_category();
        $all_sub_category = $objLegalSubCategory->get_subcategory();

        $filter = array();
        $filter['active_legal_id'] = $active_legal_id;   
        $filter['created_from'] = 'FA';
        $filter['case_id'] = $id;

        $rootdetails = $objcaseRootAction->get_case_root('', $filter);
        $body = "followupview.tpl";

        break;   


    case 'caseview':

        $cases = $objLegalCase->get_case($id);
        if ($cases) {
            $active_legal_id = $cases[0]['active_legal_id'];
        }

        $active_legal = $objActiveLegal->Get_ActiveLegal_Information(['id' => $active_legal_id]);
        $all_category = $objLegalCategory->get_category();
        $all_sub_category = $objLegalSubCategory->get_subcategory();

        $filter = array();
        $filter['active_legal_id'] = $active_legal_id;   
        $filter['created_from'] = 'FA';
        $filter['case_id'] = $id;

        $rootdetails = $objcaseRootAction->get_case_root('', $filter);
        $body = "followupcaseview.tpl";

        break;   
}
