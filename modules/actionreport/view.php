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



$objActiveLegal = new ActiveLegal();
$objLegalCase = new LegalCase();
$objThirdParty = new thirdParty();
$objDebtCollector = new DebtCollector();
$objLegalFirm = new LegalFirm();
$objLegalCategory = new Category();
$objLegalSubCategory = new ActionSubcategory();
$objcaseRootAction = new CaseRootAction();

$action = $_GET['action'];
$id = $_GET['param1'];
$page = $_GET['page'];


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'new_action') {
    // echo '<pre>';
    // print_r($_FILES);
    // echo '<pre>';
    // print_r($_POST);
    // exit;
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
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'new_action') {

        $email = trim($_POST['email']);
        $data['case_id'] = $_POST['case_id'] ?? null;
        $data['active_legal_id'] = $_POST['active_legal_id'] ?? null;
        $data['category_id'] = $_POST['category_id'] ?? null;
        $data['action_subcategory_id'] = $_POST['sub_category_id'] ?? null;
        $data['case_root_id'] = $_POST['stage'] ?? null;
        $data['date'] = $_POST['date'] ?? null;
        $data['description'] = $_POST['description'] ?? null;
        $data['email'] = $_POST['email'] ?? null;
      //  $data['uae_pass'] = $_POST['uae_pass'] ?? null;
        $data['created_by'] = $_SESSION['LOGIN_LEGAL_ID'] ?? null;

        $data['client_id'] = $_POST['client_id'] ?? null;
        $data['firm_id'] = $_POST['firm_id'] ?? null;
        $data['parent_type'] = $_POST['parent_type'] ?? null;
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
    header("location: " . ROOT_DIR . "actionreport/caseactions/.html");
    exit;
}


switch ($action) {
    case 'view':

        $all_third_party = $objThirdParty->get_legal_third_Information('', '', '', 'A');
        $all_debt_collector = $objDebtCollector->getDebtCollectorInfo();
        $all_legal_firm = $objLegalFirm->getLegalFirmInformation();
        $legal_case = $objLegalCase->get_case($id);
        $active_legal_id =  $legal_case[0]['active_legal_id'];
        $active_legal = $objActiveLegal->Get_ActiveLegal_Information(['id' => $active_legal_id]);
        $all_category = $objLegalCategory->get_category();
        $all_sub_category = $objLegalSubCategory->get_subcategory();




        $all_roots = $objLegalCase->all_get_roots('', $id, $active_legal_id);
    //     echo "<pre>";
    //  print_r($all_roots);
    //  exit;
        $selected_category_id = '';
        
        if (!empty($all_roots)) {
        
            $first = $all_roots[0];
        
            if (is_object($first) && isset($first->category)) {
                $selected_category_id = $first->category;
            } elseif (is_array($first) && isset($first['category'])) {
                $selected_category_id = $first['category'];
            }
        }
        
        // echo "<pre>";
        // print_r($all_sub_category);
        // exit;
        
//         $this->data['selected_category_id'] = $selected_category_id;
// $this->data['all_category'] = $all_category;
         
        if ($all_roots) {
            foreach ($all_roots as $rootkey => $roots) {

                $case_filter = array();
                $case_filter['created_from'] = 'CA';
                $case_filter['active_legal_id'] = $roots['active_legal_id'];
                $case_filter['case_id'] = $roots['case_id'];
                $case_filter['case_root_id'] = $roots['id'];
                $case_roots = $objcaseRootAction->get_case_root('', $case_filter);
                $last_case_root = $case_roots[0] ?? null;
                if ($last_case_root && $last_case_root['case_root_id'] == $roots['id']) {
                    $all_roots[$rootkey]['last_case_action'] = $last_case_root['description'] ?? '';
                    $all_roots[$rootkey]['last_case_date'] = $last_case_root['date'] ?? '';
                }
            }
        }



     


// echo '<pre>';
// print_r($_SESSION);
// exit;


        // echo '<pre>';
        // print_r($all_roots);
        // exit;

        $label_array = [
            'third_party' => 'Third Party',
            'debt_collector' => 'Debt Collector',
            'legal_firm' => 'Legal Firm',
            'legal_team' => 'Legal Team'
        ];
        $shifted_records = $objActiveLegal->get_shifting('', $id, '', true);

        if (!empty($shifted_records)) {
            $party_name = '';
            foreach ($shifted_records as $key => $record) {
                if ($record['legal_type'] == 'debt_collector') {
                    if (!empty($all_debt_collector)) {
                        foreach ($all_debt_collector as $debt_collector) {
                            if ($debt_collector['id'] == $record['party_name']) {
                                $shifted_records[$key]['party_name_label'] = $debt_collector['name'];
                            }
                        }
                    }
                }
                if ($record['legal_type'] == 'third_party') {
                    if (!empty($all_third_party)) {
                        foreach ($all_third_party as $third_party) {
                            if ($third_party['id'] == $record['party_name']) {
                                $shifted_records[$key]['party_name_label'] = $third_party['name'];
                            }
                        }
                    }
                }
                if ($record['legal_type'] == 'legal_firm') {
                    if (!empty($all_legal_firm)) {
                        foreach ($all_legal_firm as $legal_firm) {
                            if ($legal_firm['id'] == $record['party_name']) {
                                $shifted_records[$key]['party_name_label'] = $legal_firm['name'];
                            }
                        }
                    }
                }
                // $shifted_records[$key]['party_name_label']='$party_name';
            }
        }
}

// echo '<pre>';print_r($root_names);exit;

$body   =   "view.tpl";
