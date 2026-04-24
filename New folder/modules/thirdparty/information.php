<?php



include_once("lib/class/class.legal_third_party.php");

$ObjthirdParty = new thirdParty();



include_once("lib/class/class.legal_bank.php");

$ObjbankDetails = new bankDetails();





include_once("lib/class/class.common.php");

$objCommon = new Common();





$edit_id        =   trim($_GET['param1']);

$action         =   trim($_GET['action']);



if ($_POST) {

    $goForward = false;

    $data_input = array();

    $data_input['code']     = trim($_POST['code']);

    $data_input['name']     = trim($_POST['name']);

    $data_input['address']  = trim($_POST['address']);

    $data_input['contact_no']   = trim($_POST['contact_no']);

    $data_input['email']        = trim($_POST['email']);

    $data_input['notes']        = trim($_POST['notes']);



    $data_input['created_by']       =   $_SESSION['LOGIN_LEGAL_ID'];

    $data_input['created_by_type']  =   $_SESSION['LOGIN_LEGAL_TYPE_ID'];

    $data_input['created_on']       =   date('Y-m-d H:i:s');



    if($action=='edit'){

        $updateid           =   trim($_POST['id']);

        $bank_updateid      =   trim($_POST['ac_id']);

    }





    if (isset($_FILES['visiting_card']) && $_FILES['visiting_card']['error'] === UPLOAD_ERR_OK && $_FILES['visiting_card']['size'] > 0) {

        $uploadedFileName = $objCommon->UploadFile($_FILES['visiting_card'], 'uploads/visiting_card/', '');



        if (strpos($uploadedFileName, 'Error:') === false) {

            //echo "✅ File uploaded successfully: $uploadedFileName";

            $data_input['visiting_card'] = $uploadedFileName;

            $goForward = true;

        } else {

            // if (isset($_FILES['visiting_card'])) {

            $error_msg  =    $uploadedFileName;  // Display error messages

            $goForward = false;

            // }

        }

    }



if($data_input['name']){



    if($ObjthirdParty->Manage_thirdParty_information($data_input,$updateid)){



        if($ObjthirdParty->_inserted_id) {

            $id = $ObjthirdParty->_inserted_id;

        } else {

            $id = $edit_id;

        }



    if($id>0 && isset($_POST['ac_type']) && $_POST['ac_type']!=''){

        $bankdata                   =   array();

        $bankdata['ac_type']        =   trim($_POST['ac_type']);

        $bankdata['ac_name']        =   trim($_POST['ac_name']);

        $bankdata['bank_id']        =   trim($_POST['bank_id']);

        $bankdata['iban_no']        =   trim($_POST['iban_no']);

        $bankdata['ac_number']      =   trim($_POST['ac_number']);

        $bankdata['bank_county_id']     =   trim($_POST['bank_county_id']);

        $bankdata['swift_code']         =   trim($_POST['swift_code']);

        $bankdata['parent_id']          =   $id;

        $bankdata['parent_type']        =   'TP';



        $bankdata['created_by']         =   $_SESSION['LOGIN_LEGAL_ID'];

        $bankdata['created_by_type']    =   $_SESSION['LOGIN_LEGAL_TYPE_ID'];

        $bankdata['created_on']         =   date('Y-m-d H:i:s');

        $ObjbankDetails->manage_bank_account($bankdata,$bank_updateid);

    }









        if ($id){

            $_SESSION['PAGE_SUCCESS'] = 'You have successfully ' . ($edit_id ? 'updated' : 'added') . ' the third party profile information';

            header("location: " . ROOT_DIR . "thirdparty/information/edit/$id.html");

            exit;

        }else{

                $data   =   $_POST;

                $error_msg = 'Error : Pleasr Try Again !';

        }



        }else{

                $data   =   $_POST;

                $error_msg = 'Error : Pleasr Try Again !';

        }

    }else{

        $error_msg = VALIDATION_MSG;

    }

}else{



    switch($action){

        case 'edit':

            if ($edit_id > 0)

            $data   =   $ObjthirdParty->get_legal_third_Information($edit_id)[0];

            if(!isset($data['code'])){

                header("location: " . ROOT_DIR . "thirdparty/information.html");

                exit;

            }

$bank_detals  =   array();

$bank_detals  =   $ObjbankDetails->get_bank_account_details('',$edit_id,'TP')[0];



        break;



        case 'delete':

            if ($edit_id > 0){

                $data   =   $ObjthirdParty->get_legal_third_Information($edit_id)[0];

                if(!isset($data['code'])){

                    header("location: " . ROOT_DIR . "thirdparty/information.html");

                    exit;

                }



                $ObjthirdParty->Update_Third_Party_Records_Status($edit_id);

                $_SESSION['PAGE_SUCCESS'] = 'You have successfully deleted the third party';

                header("location: " . ROOT_DIR . "thirdparty/list.html");

                exit;

            }



        break;

        default:

            $third_party_code           =   $ObjthirdParty->get_Last_ID();

            $data['code']               =   $third_party_code;

        break;

    }

}

$actve_sub_menu = 'dashboard';

$body   =   "information.tpl";