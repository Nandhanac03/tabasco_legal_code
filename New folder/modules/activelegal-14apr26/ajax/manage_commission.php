<?php

ob_start();

session_start();

error_reporting(0);



include_once("../../../lib/config.php");

include_once("../../../lib/class/class.dbcon.php");

include_once("../../../lib/class/class.legal_active_legals.php");

include_once("../../../lib/class/class.legal_third_party.php");

include_once("../../../lib/class/class.legal_debt_collector.php");

include_once("../../../lib/class/class.legal_firm.php");

$objActiveLegal = new ActiveLegal();

$objThirdParty = new thirdParty();

$objDebtCollector = new DebtCollector();

$objLegalFirm = new LegalFirm();





if ($_POST) {

    $action = $_POST['action'];

    if ($action) {

        $user_id = $_SESSION['LOGIN_LEGAL_ID'];

        switch ($action) {

            case 'get_party':

                $category_type = $_POST['category_type'];

                $html = '';

                if ($category_type == '') {

                    $html = "<option value=''>- - select party - -</option>";

                } else {

                    $data = [];

                    switch ($category_type) {

                        case 'TP':

                            $data = $objThirdParty->get_legal_third_Information('', '', '', 'A');

                            break;

                        case 'DC':

                            $data = $objDebtCollector->getDebtCollectorInfo();

                            break;

                        case 'LF':

                            $data = $objLegalFirm->getLegalFirmInformation();

                            break;

                        case 'LT':

                            // DATA SHOULD BE ADDED IN FUTURE. DONT REMEMBER

                            include_once("../../../lib/class/class.legal_users.php");
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
            
                            break;

                        default:

                            break;

                    }

                    $html = "<option value=''>- - select party - -</option>";

                    if (!empty($data)) {

                        foreach ($data as $each_data) {

                            $html .= "<option value='{$each_data['id']}'>{$each_data['name']}</option>";

                        }

                    }

                }

                echo json_encode(['success' => true, 'message' => $html]);

                exit;

            case 'save_commission':

                if ($_POST) {

                    $active_legal_id = $_POST['edit_id'] ?? '';

                    $parent_type = $_POST['category_select'] ?? '';

                    $party_id = $_POST['party_select'] ?? '';

                    $commission = $_POST['commission_percent'] ?? '';

                    $notes = $_POST['notes'] ?? '';



                    if (!$active_legal_id || $active_legal_id == '') {

                        echo json_encode(['success' => false, 'message' => 'No Active Legal found.']);

                        exit;

                    }

                    if ($parent_type == '' || $party_id == '' || $commission == '') {

                        echo json_encode(['success' => false, 'message' => 'Fields missing.']);

                        exit;

                    }

                    $user_id = $_SESSION['LOGIN_LEGAL_ID'];



                    $input_data = [];

                    $input_data['active_legal_id'] = $active_legal_id;

                    $input_data['parent_type'] = $parent_type;

                    $input_data['party_id'] = $party_id;

                    $input_data['commission'] = $commission;

                    $input_data['notes'] = $notes;

                    $input_data['created_at'] = date('Y-m-d H:i:s');

                    $input_data['created_by'] = $user_id;

                    $input_data['updated_at'] = date('Y-m-d H:i:s');

                    $input_data['updated_by'] = $user_id;

                    $input_data['active'] = 'A';

                    echo "<pre>";

                    print_r($input_data);

                    exit;

                } else {

                    echo json_encode(['success' => false, 'message' => 'Input required.']);

                    exit;

                }

        }

    } else {

        echo json_encode(['success' => false, 'message' => 'Action required']);

        exit;

    }

} else {

    echo json_encode(['success' => false, 'message' => 'Unauthorized request']);

    exit;

}

