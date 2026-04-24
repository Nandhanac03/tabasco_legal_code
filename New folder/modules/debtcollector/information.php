<?php

// Security enhancements for session handling
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1);
ini_set('session.use_strict_mode', 1);
session_regenerate_id(true);

// Include necessary files

require_once("lib/class/class.common.php");
require_once("lib/class/class.legal_bank.php");
require_once("lib/class/class.legal_debt_collector.php");

$objCommon = new Common();
$ObjbankDetails = new bankDetails();
$ObjDebtCollector = new DebtCollector();

// Securely get input parameters
$edit_id = isset($_GET['param1']) ? intval($_GET['param1']) : 0;
$action = isset($_GET['action']) ? trim($_GET['action']) : '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data_input = [
        'code'             => htmlspecialchars(trim($_POST['code'] ?? '')),
        'name'             => htmlspecialchars(trim($_POST['name'] ?? '')),
        'address'          => htmlspecialchars(trim($_POST['address'] ?? '')),
        'contact_no'       => htmlspecialchars(trim($_POST['contact_no'] ?? '')),
        'email'            => filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL),
        'post_box_no'      => htmlspecialchars(trim($_POST['post_box_no'] ?? '')),
        'notes'            => htmlspecialchars(trim($_POST['notes'] ?? '')),
        'created_by'       => $_SESSION['LOGIN_LEGAL_ID'] ?? 0,
        'created_by_type'  => $_SESSION['LOGIN_LEGAL_TYPE_ID'] ?? 0,
        'created_on'       => date('Y-m-d H:i:s')
    ];

    $updateid = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $bank_updateid = isset($_POST['ac_id']) ? intval($_POST['ac_id']) : 0;

    // Secure File Upload Handling
    if (!empty($_FILES['visiting_card']['name'])) {
        $allowed_types = ['image/jpeg', 'image/png', 'application/pdf'];
        $max_size = 2 * 1024 * 1024; // 2MB limit

        if ($_FILES['visiting_card']['error'] === UPLOAD_ERR_OK) {
            if (in_array($_FILES['visiting_card']['type'], $allowed_types) && $_FILES['visiting_card']['size'] <= $max_size) {
                $uploadedFileName = $objCommon->UploadFile($_FILES['visiting_card'], 'uploads/visiting_card/', '');
                if (strpos($uploadedFileName, 'Error:') === false) {
                    $data_input['visiting_card'] = $uploadedFileName;
                } else {
                    $error_msg = $uploadedFileName;
                }
            } else {
                $error_msg = "Invalid file type or size exceeded.";
            }
        }
    }

    // Process debt collector
    if (!empty($data_input['name'])) {
        if ($ObjDebtCollector->manageDebtCollector($data_input, $updateid)) {
            $id = $ObjDebtCollector->_inserted_id ?: $edit_id;

            // Process bank details if provided
            if ($id > 0 && !empty($_POST['ac_type'])) {
                $bankdata                   =   array();
                $bankdata['ac_type']        =   trim($_POST['ac_type']);
                $bankdata['ac_name']        =   trim($_POST['ac_name']);
                if($_POST['bank_id'])
                $bankdata['bank_id']        =   trim($_POST['bank_id']);

                $bankdata['iban_no']        =   trim($_POST['iban_no']);
                $bankdata['ac_number']      =   trim($_POST['ac_number']);

                if($_POST['bank_county_id'])
                $bankdata['bank_county_id']     =   trim($_POST['bank_county_id']);

                $bankdata['swift_code']         =   trim($_POST['swift_code']);
                $bankdata['parent_id']          =   $id;
                $bankdata['parent_type']        =   'DC';

                $bankdata['created_by']         =   $_SESSION['LOGIN_LEGAL_ID'];
                $bankdata['created_by_type']    =   $_SESSION['LOGIN_LEGAL_TYPE_ID'];
                $bankdata['created_on']         =   date('Y-m-d H:i:s');
                $ObjbankDetails->manage_bank_account($bankdata,$bank_updateid);
            }

            // Redirect after successful operation
            $_SESSION['PAGE_SUCCESS'] = 'You have successfully ' . ($edit_id ? 'updated' : 'added') . ' the debt collector profile information';
            header("Location: " . ROOT_DIR . "debtcollector/information/edit/$id.html");
            exit;
        } else {
            $error_msg = 'Error: Please try again!';
        }
    }
}

// Action Handling
$title = "Debt Collector";
switch ($action) {
    case 'add':
        $title = "Add Debt Collector";
        break;
    case 'edit':
        $title = "Edit Debt Collector";
        $filters        = [];
        $filters['id']  = $edit_id;
        $data = $ObjDebtCollector->getDebtCollectorInfo($filters)[0];
        if (!isset($data['code']) && !isset($data['id'])) {
            header("location: " . ROOT_DIR . "debtcollector/information.html");
            exit;
        }
        $bank_detals  =   array();
        $bank_detals  =   $ObjbankDetails->get_bank_account_details('',$edit_id,'DC')[0];
        break;

        case 'delete':
            $title = "";
            $filters        = [];
            $filters['id']  = $edit_id;
            $data = $ObjDebtCollector->getDebtCollectorInfo($filters)[0];
            if (!isset($data['code']) && !isset($data['id'])) {
                header("location: " . ROOT_DIR . "debtcollector/information.html");
                exit;
            }
            $ObjDebtCollector->Update_Debt_Collector_Records_Status($edit_id);
            $_SESSION['PAGE_SUCCESS'] = 'You have successfully deleted the Debt Collector ';
            header("location: " . ROOT_DIR . "debtcollector/list.html");
            exit;


    case 'view':
        $title = "View Debt Collector";
        break;
    default:
        $debt_collector_code = $ObjDebtCollector->getLastID();
        $data['code'] = $debt_collector_code;
        break;
}
$actve_sub_menu = 'dashboard';
$body = "information.tpl";
?>
