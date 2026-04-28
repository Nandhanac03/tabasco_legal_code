<?php
ob_start();
session_start();
# including files here
include_once("lib/config.php");
include_once("lib/class/class.dbcon.php");
include_once("lib/class/class.legal_category.php");
include_once("lib/class/class.legal_court.php");
include_once("lib/class/class.legal_users.php");
include_once("lib/class/class.legal_active_legals.php");
include_once("lib/class/class.legal_case.php");
include_once("lib/class/class.legal_case_mode.php");
include_once("lib/class/class.legal_users.php");

$objCategory     = new Category();
$objCourt        = new Court();
$objUsers        = new UsersClass();
$objActiveLegal  = new ActiveLegal();
$objLegalCase    = new LegalCase();
$objLegalCaseMode = new Case_mode();
$ObjUsersClass   = new UsersClass();

$activeLegalId = $_SESSION['ACTIVE_LEGAL_ID'];

$categories    = $objCategory->get_category();
$courts        = $objCourt->get_court();
$active_legals = $objActiveLegal->Get_ActiveLegal_Information();
$activeLegal   = $objActiveLegal->Get_ActiveLegal_Information(['id' => $activeLegalId]);
$case_modes    = $objLegalCaseMode->get_case_mode();

$edit_id       = trim($_GET['param1']);
$action        = trim($_GET['action']);

$disabled_field = $edit_id ? '' : 'disabled';

if ($action == 'edit') {
    $current_legal_case = $objLegalCase->get_case($edit_id);
    if (!$current_legal_case) {
        header("location: " . ROOT_DIR . "activelegal/list.html");
        exit;
    }
}

$client_id = $activeLegal[0]['client'] ?? null;

$plantiffs = [];
if ($client_id) {
    $plantiffs = $objLegalCase->get_plantiffs_by_client($client_id);
}

$defendant = [];
if ($client_id) {
    $defendant = $objLegalCase->get_defendant_by_client($client_id);
}

$list1 = $ObjUsersClass->get_all_Users(null, '', 23) ?: [];
$list2 = $ObjUsersClass->get_all_Users(null, '', 24) ?: [];
$lawyerusersList = array_merge($list1, $list2);

$error_msg = ''; // CHANGE 1: Initialize error_msg to avoid undefined variable warning

if ($_POST) {

    $go_forward = true;

    // CHANGE 2: Removed 'plaintiff' from required validation 
    // (it was already commented out in JS validation — keeping consistent)
    // CHANGE 3: Removed 'case_date' from required validation 
    // (case_date field was removed/commented out in the form)
    $required_fields = [
        'code'          => $_POST['code']          ?? '',
        'case_number'   => $_POST['case_number']   ?? '',
        'category'      => $_POST['category']      ?? '',
        'court'         => $_POST['court']         ?? '',
        'register_date' => $_POST['register_date'] ?? '',
        'case_mode'     => $_POST['case_mode']     ?? '',
        'lawyer'        => $_POST['lawyer']        ?? '',
        'location'      => $_POST['location']      ?? '',
    ];

    foreach ($required_fields as $field => $value) {
        if (trim($value) == '') {
            $error_msg = "Please fill the required fields.";
            $go_forward = false;
            break;
        }
    }

    if ($go_forward) {
        $user_id = $_SESSION['LOGIN_LEGAL_ID'];

        $input_data = [];
        $input_data['active_legal_id']           = $_POST['code'];
        $input_data['case_number']               = $_POST['case_number'];
        $input_data['category']                  = $_POST['category'];
        $input_data['court']                     = $_POST['court'];
        $input_data['plaintiff']                 = $_POST['plaintiff']  ?? ''; // CHANGE 4: Not required but still saved if provided
        $input_data['defendant']                 = $_POST['defendant']  ?? ''; // CHANGE 4: Not required but still saved if provided
        $input_data['register_date']             = $_POST['register_date'];
        $input_data['case_mode']                 = $_POST['case_mode'];
        $input_data['lawyer']                    = $_POST['lawyer'];
        $input_data['location']                  = $_POST['location'];
        // CHANGE 3: Removed case_date — field no longer exists in the form
        $input_data['note']                      = $_POST['note'] ?? '';
        // CHANGE 5: These three fields are now editable and submitted from the form
        $input_data['total_outstanding']         = $_POST['total_outstanding']         ?? '0';
        $input_data['outstanding_with_cheque']   = $_POST['outstanding_with_cheque']   ?? '0';
        $input_data['outstanding_without_cheque'] = $_POST['outstanding_without_cheque'] ?? '0';
        $input_data['created_id']                = $user_id;
        $input_data['created_on']                = date('Y-m-d H:i:s');
        $input_data['updated_id']                = $user_id;
        $input_data['updated_on']                = date('Y-m-d H:i:s');
        $input_data['status']                    = 'A';

        if ($objLegalCase->saveCase($input_data, $edit_id)) {
            if ($objLegalCase->_inserted_id) {
                $id = $objLegalCase->_inserted_id;
            } else {
                $id = $edit_id;
            }

            $root_array = [];
            $root_array['case_id']        = $id;
            $root_array['active_legal_id'] = $_POST['code'];
            $root_array['court']          = $_POST['court'];
            $root_array['stage']          = 1;
            $root_array['lawyer']         = $_POST['lawyer'];
            $root_array['register_date']  = $_POST['register_date'];
            $root_array['category']       = $_POST['category'];
            $root_array['created_on']     = date('Y-m-d H:i:s');
            $root_array['created_by']     = $user_id;
            $root_array['status']         = 'A';

            $exist_root = $objLegalCase->get_roots('', $id, $_POST['code'], 1);

            if ($exist_root) {
                $root_id = $exist_root[0]['id'];
                $root_array['updated_on'] = date('Y-m-d H:i:s');
                $root_array['updated_by'] = $user_id;
                $objLegalCase->saveRoots($root_array, $root_id);
            } else {
                $objLegalCase->saveRoots($root_array);
            }

            if ($id) {
                $_SESSION['PAGE_SUCCESS'] = 'You have successfully ' . ($edit_id ? 'updated' : 'added') . ' the Case information';
                header("location: " . ROOT_DIR . "case/information/edit/$id.html");
                exit;
            }
        }
    }
}

$body = "information.tpl";