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





function getParty($party_type = '')

{

    global $objThirdParty, $objDebtCollector, $objLegalFirm;

    $html = '';

    if ($party_type == '') {

        $html = "<option value=''>- - select - -</option>";
    } else {

        $data = [];

        switch ($party_type) {

            case 'third_party':

                $data = $objThirdParty->get_legal_third_Information('', '', '', 'A');

                break;

            case 'debt_collector':

                $data = $objDebtCollector->getDebtCollectorInfo();

                break;

            case 'legal_firm':

                $data = $objLegalFirm->getLegalFirmInformation();


                break;

            case 'legal_team':
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

        $html = "<option value=''>- - select - -</option>";

        if (!empty($data)) {

            foreach ($data as $each_data) {

                $html .= "<option value='{$each_data['id']}'>{$each_data['name']}</option>";
            }
        }
    }

    return $html;
}





if ($_POST) {

    $action = $_POST['action'];

    if ($action) {

        $user_id = $_SESSION['LOGIN_LEGAL_ID'];

        switch ($action) {

            case 'getParty':

                $party_type = $_POST['party_type'];

                $party_info = getParty($party_type);

                echo json_encode(['success' => true, 'html' => $party_info]);

                exit;

            case 'saveShift':

                $id = isset($_POST['id']) ? $_POST['id'] : '';

                $active_legal_id = isset($_POST['active_legal_id']) ? $_POST['active_legal_id'] : '';

                $party_type = isset($_POST['party_type']) ? $_POST['party_type'] : '';

                $party_name = isset($_POST['party_name']) ? $_POST['party_name'] : '';

                $shift_date = isset($_POST['shift_date']) ? $_POST['shift_date'] : '0000-00-00';

                if (!$party_type) {

                    echo json_encode(['success' => false, 'message' => "Legal type is required."]);

                    exit;
                }

                if (!$party_name) {

                    echo json_encode(['success' => false, 'message' => "Firm/Party is required."]);

                    exit;
                }

                if ($shift_date == '0000-00-00') {

                    echo json_encode(['success' => false, 'message' => "Shift Date is required."]);

                    exit;
                }

                $filters = array();

                $filters['status'] = 'A';

                $filters['id'] = $active_legal_id;

                $active_legal_data = $objActiveLegal->Get_ActiveLegal_Information($filters);

                if (empty($active_legal_data)) {

                    echo json_encode(['success' => false, 'message' => "No Active Legal found"]);

                    exit;
                }

                $active_legal_data = $active_legal_data[0];

                // echo "<pre>";

                // print_r($active_legal_data);

                // exit;

                $input_data = [];

                $input_data['active_legal_id'] = $active_legal_id;



                // $input_data['start_date'] = $start_date;

                $input_data['start_date'] = $shift_date;

                if ($id == '') {

                    $input_data['created_by'] = $user_id;

                    $input_data['created_at'] = date('Y-m-d H:i:s');
                }

                $input_data['updated_by'] = $user_id;

                $input_data['updated_at'] = date('Y-m-d H:i:s');

                $input_data['status'] = 'A';

                $input_data['legal_type'] = $party_type;

                $input_data['party_name'] = $party_name;

                $available_records = $objActiveLegal->get_shifting('', $active_legal_id);


                if ($available_records) {
                    $new_input_data = [];
                    $new_input_data['shifted_date'] = $shift_date;
                    $new_input_data['updated_by'] = $user_id;
                    $new_input_data['updated_at'] = date('Y-m-d H:i:s');
                    $objActiveLegal->shift_active_legal($new_input_data, $available_records[0]['id']);
                }

                // $input_data['start_date'] = $available_records[0]['shifted_date'];

                // if (empty($available_records)) {

                //     $input_data['start_date'] = date('Y-m-d', strtotime($active_legal_data['created_on']));

                //     if (!$objActiveLegal->shift_active_legal($input_data, $id)) {

                //         echo json_encode(['success' => false, 'message' => "Error shifting initial data"]);

                //         exit;

                //     }

                // } else {

                //     $input_data['start_date'] = $available_records[0]['shifted_date'];

                // }

                $label_array = [

                    'third_party' => 'Third Party',

                    'legal_firm' => 'Legal Firm',

                    'debt_collector' => 'Debt Collector',

                    'legal_team' => 'Legal Team'

                ];

                $label_id_array_from_config = [

                    'third_party' => '1',

                    'legal_firm' => '2',

                    'debt_collector' => '3',

                    'legal_team' => '4'

                ];



                if ($objActiveLegal->shift_active_legal($input_data, $id)) {

                    $update_data = [];

                    $update_data['dateon'] = $active_legal_data['dateon'];

                    $update_data['code'] = $active_legal_data['code'];

                    $update_data['user_id'] = $active_legal_data['user_id'];

                    $update_data['client'] = $active_legal_data['client'];

                    $update_data['status'] = 'A';

                    $update_data['category'] = $label_id_array_from_config[$party_type];

                    $update_data['agencies_id'] = $party_name;

                    $update_data['updated_on'] = date('Y-m-d H:i:s');

                    $input_data['updated_id'] = $user_id;




                    if ($objActiveLegal->Manage_ActiveLegal($update_data, $active_legal_id)) {

                        echo json_encode(['success' => true, 'message' => "Successfully shifted to $label_array[$party_type]"]);

                        exit;
                    } else {

                        echo json_encode(['success' => false, 'message' => "Error while updating active legal data !"]);

                        exit;
                    }
                } else {

                    echo json_encode(['success' => false, 'message' => "Error while saving !"]);

                    exit;
                }

            default:

                echo json_encode(['success' => false, 'message' => "No Action"]);

                exit;
        }
    } else {

        echo json_encode(['success' => false, 'message' => 'Invalid Action performed']);

        exit;
    }
} else {

    echo json_encode(['success' => false, 'message' => 'Invalid Request']);

    exit;
}
