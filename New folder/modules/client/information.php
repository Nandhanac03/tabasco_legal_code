<?php

include_once("lib/class/class.common.php");
$objCommon = new Common();

include_once("lib/class/class.legal_common_selection.php");
$objCommonSelection = new CommonSelection();

include_once("lib/class/class.legal_client.php");
$objClients = new Clients();

$edit_id = trim($_GET['param1']);
$action = trim($_GET['action']);


if ($_POST) {
    unset($_SESSION['PAGE_SUCCESS']);
    

    $input_data                 = array();
    $input_data['type']         = trim($_POST['which_type_user']);
    $_POST['marketing']         = $input_data['marketing'];
    $array_client_data = array();
    $goForward = true;
    if ($input_data['type'] == 'I') {
        $input_data['marketing']    = trim($_POST['select_internal']);
        $input_data['client']       = trim($_POST['name']);
        if(!$edit_id){
            $input_data['client_from']  = 'legal';
        }
        if (trim($_POST['select_internal']) == '0') {
            $error_msg = "Please select Internal Staff";
            $goForward = false;
        }

        if (trim($_POST['name']) == '') {
            $error_msg = "Please enter client name";
            $goForward = false;
        }

        $input_data['name'] = trim($_POST['name']);
        $input_data['behalf_of'] = trim($_POST['behalf_of']);
    } else if ($input_data['type'] == 'M') {
        // $input_data['marketing']    = trim($_POST['select_marketing']);
        // $input_data['client']       = trim($_POST['select_client']);
        // if(trim($_POST['select_marketing']) == '') {
        //     $error_msg = "Please select Internal Staff";
        //     $goForward = false;
        // }
        // if(trim($_POST['select_client']) == '') {
        //     $error_msg = "Please select client";
        //     $goForward = false;
        // }
        // if ($input_data['client'] != '' && $input_data['marketing'] != '') {
        //     $array_client_data = $objCommonSelection->get_client($input_data['client'], $input_data['marketing'])[0];
        //     $input_data['name'] = trim($array_client_data['customer_name']);
        //     $input_data['refer_id'] = trim($array_client_data['customer_Id']);
        // }

        $input_data['marketing'] = trim($_POST['select_marketing'] ?? '');
        $input_data['client']    = trim($_POST['select_client'] ?? '');
        $input_data['name']      = trim($_POST['client_name'] ?? '');

        $goForward = true;

        if ($input_data['marketing'] === '') {
            $error_msg = "Please select Internal Staff";
            $goForward = false;
        }

        if ($input_data['client'] === '' && $input_data['name'] === '') {
            $error_msg = "Please select client or add a new client";
            $goForward = false;
        }

        /* ---- Existing Client Selected ---- */
        if ($goForward && $input_data['client'] !== '') {

            $array_client_data = $objCommonSelection
                ->get_client($input_data['client'], $input_data['marketing']);
                if(!$edit_id){
                    $input_data['client_from']  = 'erp';
                }
            if (!empty($array_client_data)) {
                $array_client_data = $array_client_data[0];
                
                $input_data['name']     = trim($array_client_data['customer_name']);
                $input_data['refer_id'] = trim($array_client_data['customer_Id']);
            } else {
                $error_msg = "Invalid client selected";
                $goForward = false;
            }
        }

        /* ---- New Client Added ---- */
        if ($goForward && $input_data['client'] === '' && $input_data['name'] !== '') {
            if(!$edit_id){
                $input_data['client_from']  = 'legal';
            }
        }
    }

    if (!$edit_id) {

        if ($input_data['client']) {
            // Fetch client info
            $result = $objClients->Get_Client_Information('', '', '', '', '', 0, 0, '', '', '', $input_data['client']);

            // ✅ Check if any record exists
            if (!empty($result) && is_array($result)) {

                // Take first row
                $array_validate = $result[0];

                $validate_refer_id = $array_validate['refer_id'] ?? null;

                if (!empty($array_validate)) {  // ✅ Safe check
                    $error_msg = "Client already exists";
                    $goForward = false;
                }
            }
        } else if ($input_data['name']) {
            // Fetch client info
            $result = $objClients->Get_Client_Information('', $input_data['name'], '', '', '', 0, 0, '', '', '', '');

            // ✅ Check if any record exists
            if (!empty($result) && is_array($result)) {

                // Take first row
                $array_validate = $result[0];

                if (!empty($array_validate)) {  // ✅ Safe check
                    $error_msg = "Client already exists";
                    $goForward = false;
                }
            }
        }
    }



    if ($goForward == true) {
        $input_data['code'] = trim($_POST['code']);
        $input_data['office_address'] = trim($_POST['office_address']);
        $input_data['contact_person'] = trim($_POST['contact_person']);
        $input_data['designation'] = trim($_POST['designation']);
        $input_data['email'] = trim($_POST['email']);
        $input_data['land_number'] = trim($_POST['land_number']);
        $input_data['mobile_number'] = trim($_POST['mobile_number']);
        $input_data['fax_number'] = trim($_POST['fax_number']);
        $input_data['po_number'] = trim($_POST['po_number']);
        $input_data['website'] = trim($_POST['website']);


        /* Upload */

        if (isset($_FILES['visiting_card']) && $_FILES['visiting_card']['error'] === UPLOAD_ERR_OK && $_FILES['visiting_card']['size'] > 0) {
            $uploadedFileName = $objCommon->UploadFile($_FILES['visiting_card'], 'uploads/visiting_card/', '');

            if (strpos($uploadedFileName, 'Error:') === false) {
                //echo "✅ File uploaded successfully: $uploadedFileName";
                $input_data['visiting_card'] = $uploadedFileName;
                $goForward = true;
            } else {
                // if (isset($_FILES['visiting_card'])) {
                $error_msg = $uploadedFileName;  // Display error messages
                $goForward = false;
                // }
            }
        }
    }
    if ($goForward == true) {
        if ($input_data['marketing'] != '' && ($input_data['client'] != '' || $input_data['name'] != '')) {
            // if(!isset($edit_id)){
            //     $client_code                =   $objClients->Get_Last_Client_ID();
            //     $input_data['code']         =   $client_code;
            // }



            if ($objClients->Manage_Client_information($input_data, $edit_id)) {

                if ($objClients->_inserted_id) {
                    $id = $objClients->_inserted_id;
                } else {
                    $id = $edit_id;
                }


                if ($id) {
                    $_SESSION['PAGE_SUCCESS'] = 'You have successfully ' . ($edit_id ? 'updated' : 'added') . ' the client profile information';
                    header("location: " . ROOT_DIR . "client/information/edit/$id.html");
                    exit;
                }
            } else {
            }
        } else {
            $error_msg = VALIDATION_MSG;
        }
    }
    $data = $_POST;
    $data['marketing'] = $input_data['marketing'];
} else {

    switch ($action) {
        case 'edit':
            $array_client_data = array();
            if ($edit_id > 0)
                $data = $objClients->Get_Client_Information($edit_id)[0];
            // echo '<pre>';
            // print_r($data);
            // exit;
            if (!isset($data['code']) && !isset($data['marketing'])) {
                header("location: " . ROOT_DIR . "client/information.html");
                exit;
            }
            break;
        case 'delete':
            $array_client_data = array();
            if ($edit_id > 0)
                $data = $objClients->Get_Client_Information($edit_id)[0];
            if (!isset($data['code']) && !isset($data['marketing'])) {
                header("location: " . ROOT_DIR . "client/information.html");
                exit;
            }
            $objClients->Update_Client_Records_Status($edit_id);
            $_SESSION['PAGE_SUCCESS'] = 'You have successfully deleted the client';
            header("location: " . ROOT_DIR . "client/list.html");
            exit;
            break;
        default:
            $client_code = $objClients->Get_Last_Client_ID();
            $data['code'] = $client_code;
            break;
    }
}



$array_marketing = array();
$array_marketing = $objCommonSelection->get_marketing();

$array_behalf_of_users = array();
$array_behalf_of_users = $objCommonSelection->get_all_users('yes');

$array_internal_staff = array();
$array_internal_staff = $objCommonSelection->get_all_users('yes', 22);

$actve_sub_menu = 'dashboard';
$body = "information.tpl";
