<?php

include_once("lib/class/class.common.php");
$objCommon = new Common();

include_once("lib/class/class.legal_firm.php");
$ObjLegalFirm = new LegalFirm();

include_once("lib/class/class.legal_bank.php");
$ObjbankDetails = new bankDetails();


$edit_id        =   trim($_GET['param1']);
$action         =   trim($_GET['action']);

if($_POST){

    $goForward = false;
    $data_input = array();
    $data_input['code']             = trim($_POST['code']);
    $data_input['name']             = trim($_POST['name']);
    $data_input['address']          = trim($_POST['address']);
    $data_input['contact_no']       = trim($_POST['contact_no']);
    $data_input['email']            = trim($_POST['email']);
    $data_input['post_box_no']      = trim($_POST['post_box_no']);
    $data_input['notes']            = trim($_POST['notes']);

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
       if($ObjLegalFirm->manageLegalFirmInformation($data_input,$updateid)){
            if($ObjLegalFirm->_inserted_id) {
                $id = $ObjLegalFirm->_inserted_id;
            } else {
                $id = $edit_id;
            }
       }

            if($id>0 && isset($_POST['ac_type']) && $_POST['ac_type']!=''){
                $bankdata                   =   array();
                $bankdata['ac_type']        =   trim($_POST['ac_type']);
                $bankdata['ac_name']        =   trim($_POST['ac_name']);
                if(isset($_POST['bank_id']))
                $bankdata['bank_id']        =   trim($_POST['bank_id']);
                $bankdata['iban_no']        =   trim($_POST['iban_no']);
                $bankdata['ac_number']      =   trim($_POST['ac_number']);
                if(isset($_POST['bank_county_id']))
                $bankdata['bank_county_id']     =   trim($_POST['bank_county_id']);
                $bankdata['swift_code']         =   trim($_POST['swift_code']);
                $bankdata['parent_id']          =   $id;
                $bankdata['parent_type']        =   'LF';

                $bankdata['created_by']         =   $_SESSION['LOGIN_LEGAL_ID'];
                $bankdata['created_by_type']    =   $_SESSION['LOGIN_LEGAL_TYPE_ID'];
                $bankdata['created_on']         =   date('Y-m-d H:i:s');
                $ObjbankDetails->manage_bank_account($bankdata,$bank_updateid);
            }



        if ($id){
            $_SESSION['PAGE_SUCCESS'] = 'You have successfully ' . ($edit_id ? 'updated' : 'added') . ' the legal firm profile information';
            header("location: " . ROOT_DIR . "legalfirm/information/edit/$id.html");
            exit;
        }else{
                $data   =   $_POST;
                $error_msg = 'Error : Pleasr Try Again !';
        }

    }else{
        $data   =   $_POST;
        $error_msg = VALIDATION_MSG;
    }

}else{
    switch($action){
        case 'edit':
            $data = $ObjLegalFirm->getLegalFirmInformation($edit_id)[0];
            if (!isset($data['code']) && !isset($data['id'])) {
                header("location: " . ROOT_DIR . "legalfirm/information.html");
                exit;
            }
            $bank_detals  =   array();
            $bank_detals  =   $ObjbankDetails->get_bank_account_details('',$edit_id,'LF')[0];
            break;
            case 'delete':
                $data = $ObjLegalFirm->getLegalFirmInformation($edit_id)[0];
                $bank_detals  =   array();
                $bank_detals  =   $ObjbankDetails->get_bank_account_details('',$edit_id,'LF')[0];

                if (!isset($data['code']) && !isset($data['id'])) {
                    header("location: " . ROOT_DIR . "legalfirm/information.html");
                    exit;
                }

                $ObjLegalFirm->Update_Firms_Records_Status($edit_id);
                $_SESSION['PAGE_SUCCESS'] = 'You have successfully deleted the Legal Firm';
                header("location: " . ROOT_DIR . "legalfirm/list.html");
                exit;

                break;

            default:
            $legal_firm_code           =   $ObjLegalFirm->getLastID();
            $data['code']              =   $legal_firm_code;
            break;
    }
}


$actve_sub_menu             =   'dashboard';
$body                       =   "information.tpl";