<?php

ob_start();

session_start();

# including files here

include_once("lib/class/class.legal_active_legals.php");

$objActiveLegal = new ActiveLegal();

include_once("lib/class/class.legal_common_selection.php");

$objCommonSelection = new CommonSelection();
include_once("lib/class/class.legal_temp_case.php");

$objTempLegalCase = new LegalTempCase();

include_once("lib/class/class.legal_collection.php");
$objCollection = new Collection();
include_once("lib/class/class.legal_expense.php");
$objExpense = new Expense();


$edit_id = trim($_GET['param1']);

$action = trim($_GET['action']);


if ($_POST) {

    $user_id = '';
    $client  = '';
    $client_type = '';
    if ($_POST['which_type_user'] == 'marketing') {
        $user_id = $_POST['select_marketing'] ?? null;
        $client  = $_POST['select_client'] ?? null;
        // $client_type = 'M';
    } else if ($_POST['which_type_user'] == 'internal') {
        $user_id = $_POST['select_internal'] ?? null;
        $client  = $_POST['select_Internalclient'] ?? null;
        // $client_type = 'I';
    }


    if ($_POST['dateon'] != '' && $_POST['code'] != '' && $user_id != '' && $client != '' && $_POST['category'] != '' && $_POST['agencies_id'] != '') {
        $is_edit = false;
        if ($edit_id > 0 && $action == 'edit') {
            $update_id = $edit_id;
            $is_edit = true;
        } else {
            $update_id = '';
        }
        $input_data = array();
        //$input_data['code'] = $_POST['code'];
        $input_data['dateon'] = trim($_POST['dateon']);
        $input_data['user_id']  = trim($user_id);
        $input_data['client']   = trim($client);
        $input_data['category'] = trim($_POST['category']);
        $input_data['agencies_id']  = trim($_POST['agencies_id']);
        $input_data['notes']        = trim($_POST['notes']);
        // $input_data['client_type']        = $client_type;

        $input_data['total_outstanding']            = trim($_POST['total_outstanding']);
        $input_data['outstanding_with_cheque']      = trim($_POST['outstanding_with_cheque']);
        $input_data['outstanding_without_cheque']   = trim($_POST['outstanding_without_cheque']);
        $input_data['claim_amount']    = !empty($_POST['claim_amount']) ? trim($_POST['claim_amount']) : 0.0;
        $input_data['collected_amount']    = !empty($_POST['collected_amount']) ? trim($_POST['collected_amount']) : 0.0;
        $input_data['balance_claim']   = !empty($_POST['balance_claim']) ? trim($_POST['balance_claim']) : 0.0;
        // $input_data['expense_amount']  = trim($_POST['expense_amount']);
        $input_data['expense_amount']  =  !empty($_POST['expense_amount']) ? trim($_POST['expense_amount']) : 0.0;
        $active_legal_id = '';
        if (isset($input_data)) {
            if ($objActiveLegal->Manage_ActiveLegal($input_data, $update_id)) {
                if ($objActiveLegal->_inserted_id) {
                    $id = $objActiveLegal->_inserted_id;
                    $currentActiveLegal =   $objActiveLegal->Get_ActiveLegal_Information(['id' => $id]);
                    $new_array = array();
                    $new_array['active_legal_id'] = $active_legal_id = $currentActiveLegal[0]['id'];
                    $new_array['party_name'] = $currentActiveLegal[0]['agencies_id'];
                    $new_array['start_date'] = $currentActiveLegal[0]['dateon'];
                    $new_array['created_at'] = date('Y-m-d H:i:s');
                    $new_array['created_by'] =  $_SESSION['LOGIN_LEGAL_ID'];
                    $new_array['status'] =  'A';
                    $category = $currentActiveLegal[0]['category'];
                    $label_id_array_from_config = [
                        '1' => 'third_party',
                        '2' => 'legal_firm',
                        '3' => 'debt_collector',
                        '4' => 'legal_team'
                    ];
                    $new_array['legal_type'] = isset($label_id_array_from_config[$category]) ? $label_id_array_from_config[$category] : null;
                    $objActiveLegal->shift_active_legal($new_array, '');
                    if (empty($is_edit)) {
                        $temp_array = array();
                        do {
                            $temp_case_number = 'precase_' . random_int(1000, 99999);


                            $is_temp_caseno = $objTempLegalCase->getTempCase([
                                'temp_case_number' => $temp_case_number
                            ]);
                        } while (!empty($is_temp_caseno));

                        $temp_array['temp_case_number'] = $temp_case_number;
                        $temp_array['active_legal_id'] = $active_legal_id;
                        $temp_array['client_id'] = trim($client);
                        $temp_array['user_id'] = trim($user_id);
                        $temp_array['agencies_id'] = trim($_POST['agencies_id']);
                        $temp_array['category'] = trim($_POST['category']);
                        $temp_array['register_date'] = trim($_POST['dateon']);
                        $temp_array['total_outstanding'] = trim($_POST['total_outstanding']);
                        $temp_array['outstanding_with_cheque'] = trim($_POST['outstanding_with_cheque']);
                        $temp_array['outstanding_without_cheque'] = trim($_POST['outstanding_without_cheque']);
                        $temp_array['created_id'] = $_SESSION['LOGIN_LEGAL_ID'];
                        $temp_array['created_on'] = date('Y-m-d H:i:s');
                        $temp_array['status'] = 'A';
                        $objTempLegalCase->saveTempCase($temp_array);
                    }
                } else {

                    $id = $edit_id;
                }

                if ($id) {

                    $_SESSION['PAGE_SUCCESS'] = 'You have successfully ' . ($edit_id ? 'updated' : 'added') . ' the Active Legal information';

                    header("location: " . ROOT_DIR . "activelegal/information/edit/$id.html");

                    exit;
                }
            }
        }
    } else {
        $data['error'] = VALIDATION_MSG;
        $data = $_POST;
    }
} else {

    switch ($action) {
        case 'edit':
            $filters = array();
            $filters['status'] = 'A';
            $filters['id'] = $edit_id;
            $array_active_legal_data = array();
            if ($edit_id > 0)
                $data = $objActiveLegal->Get_ActiveLegal_Information($filters)[0];

            $total_collection = $objCollection->total_collection($edit_id);
            $data['total_collection'] = $total_collection;
            $total_Expense = $objExpense->total_expense($edit_id);
            $data['total_Expense'] = $total_Expense;

            // echo '<pre>';
            // print_r($data);
            // exit;

            if (!isset($data['code']) && !isset($data['user_id'])) {
                header("location: " . ROOT_DIR . "activelegal/list.html");
                exit;
            }
            break;

        default:

            $active_legal_code = $objActiveLegal->Get_Last_ActiveLegal_ID();

            $data['code'] = $active_legal_code;

            break;
    }
}


$array_users = array();

$array_users = $objCommonSelection->get_all_users('yes', '21,1');
$array_internal_staff = array();
$array_internal_staff = $objCommonSelection->get_all_users('yes', 22);
$actve_sub_menu = 'dashboard';

$body = "information.tpl";
