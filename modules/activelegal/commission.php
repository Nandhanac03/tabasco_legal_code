<?php

ob_start();

session_start();

# including files here

include_once("lib/config.php");

include_once("lib/class/class.dbcon.php");

include_once("lib/class/class.legal_active_legals.php");

include_once("lib/class/class.legal_third_party.php");

include_once("lib/class/class.legal_debt_collector.php");

include_once("lib/class/class.legal_firm.php");


$objActiveLegal = new ActiveLegal();

$objThirdParty = new thirdParty();

$objDebtCollector = new DebtCollector();

$objLegalFirm = new LegalFirm();

$action             =   trim($_GET['action']);

$active_legal_id    =   trim($_GET['param1']);

$edit_id            =   trim($_GET['param1']);

// echo '<pre>';print_r($active_legal_id);exit;



if (!$active_legal_id) {
    header("location: " . ROOT_DIR . "permission_denied.php");
    exit;
}

if ($active_legal_id) {
    $commision_details = $objActiveLegal->get_commission('', $active_legal_id);
    if ($commision_details) {
        foreach ($commision_details as $key => $value) {
            if ($value['parent_type'] == 'TP') {
                $data = $objThirdParty->get_legal_third_Information($value['party_id'], '', '', 'A');
            } else if ($value['parent_type'] == 'DC') {
                $data = $objDebtCollector->getDebtCollectorInfo(['id' => $value['party_id']]);
            } else if ($value['parent_type'] == 'LF') {
                $data = $objLegalFirm->getLegalFirmInformation(['id' => $value['party_id']]);                
            } else if ('LT') {
                // DATA SHOULD BE ADDED IN FUTURE. DONT REMEMBER
                include_once("lib/class/class.legal_users.php");
                $ObjUsersClass = new UsersClass();
                // DATA SHOULD BE ADDED IN FUTURE. DONT REMEMBER
                $array_data = $ObjUsersClass->get_all_Users(null, '', 23);
                // Convert to desired format
                $data = array_map(function ($item) {
                    return [
                        'id' => (string) $item['user_Id'],   // Convert to string if needed
                        'name' => $item['user_name'],
                        'code' => '',
                    ];
                }, $array_data);
            }

            if(!empty($data)){
                $commision_details[$key]['party_name'] = $data[0]['name'];
            }
        }
    }
}



$user_id = $_SESSION['LOGIN_LEGAL_ID'];

if ($_POST) {

    $active_legal_id_input = $active_legal_id;

    $parent_type = $_POST['category_select'] ?? '';

    $party_id = $_POST['party_select'] ?? '';

    $commission = $_POST['commission_percent'] ?? '';

    $notes = $_POST['notes'] ?? '';

    $go_forward = true;

    if (!$active_legal_id || $active_legal_id == '') {

        $error_msg = 'No Active Legal found.';

        $go_forward = false;
    }

    if ($parent_type == '' || $party_id == '' || $commission == '') {

        $error_msg = 'Fields missing.';

        $go_forward = false;
    }

    if ($go_forward) {



        $input_data = [];

        $input_data['active_legal_id'] = $active_legal_id_input;

        $input_data['parent_type'] = $parent_type;

        $input_data['party_id'] = $party_id;

        $input_data['commission'] = $commission;

        $input_data['notes'] = $notes;

        $input_data['created_at'] = date('Y-m-d H:i:s');

        $input_data['created_by'] = $user_id;

        $input_data['updated_at'] = date('Y-m-d H:i:s');

        $input_data['updated_by'] = $user_id;

        $input_data['active'] = 'A';

        if ($objActiveLegal->save_commission($input_data)) {

            $_SESSION['PAGE_SUCCESS'] = 'You have successfully ' . ($edit_id ? 'updated' : 'added') . ' the commission information';

            header("location: " . ROOT_DIR . "activelegal/commission/edit/$active_legal_id.html");

            exit;
        } else {

            $error_msg = 'Error occured while saving';
        }
    }

    // echo "<pre>";

    // print_r($input_data);

    // exit;

}

// echo"<pre>";print_r($objActiveLegal->get_commission());exit;

$actve_sub_menu = 'dashboard';

$body = "commission.tpl";
