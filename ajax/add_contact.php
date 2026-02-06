<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
// Include necessary files
include_once("../lib/config.php");
include_once("../lib/class/class.dbcon.php");


include_once("../lib/class/class.legal_contact.php");
$ObjContact  =   new Contact();

if ($_POST) {

    // CSRF token validation
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid CSRF token.']);
        exit;
    }

    $input_data = array();
    $goForward = true;
    // Validate form inputs
$parentID = isset($_POST['hid_parentID']) ? htmlspecialchars($_POST['hid_parentID']) : null;
    /*$parentID means client , third party ,debt collector ect   */
$contactName = isset($_POST['contactName']) ? htmlspecialchars($_POST['contactName']) : null;
$postmodule = isset($_POST['hid_module']) ? htmlspecialchars($_POST['hid_module']) : null;
$postpage = isset($_POST['hid_page']) ? htmlspecialchars($_POST['hid_page']) : null;

$contact_number = isset($_POST['contactNo']) ? htmlspecialchars($_POST['contactNo']) : null;
$profession = isset($_POST['contactDesignation']) ? htmlspecialchars($_POST['contactDesignation']) : null;
$email = isset($_POST['contactEmail']) ? htmlspecialchars($_POST['contactEmail']) : null;

    if (!$postmodule || !$postpage) {
        $goForward = false;
        $response['status'] = 'error';
        $response['message'] = VALIDATION_MSG;
        echo json_encode($response);
        exit;
    }


    if (!$parentID || !$contactName) {
        $goForward = false;
        $response['status'] = 'error';
        $response['message'] = VALIDATION_MSG;
        echo json_encode($response);
        exit;
    }



    if ($_FILES['contactVisitingCard']['size'] > 0) {

        $uploadDir = '../uploads/visiting_card' . DIRECTORY_SEPARATOR;
        // Create directory if it doesn't exist
        if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
            echo json_encode(['success' => false, 'message' => 'Failed to create upload directory.']);
            exit;
        }
        // File upload validation
        $file = $_FILES['contactVisitingCard'];
        $allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
        $maxFileSize = 1 * 1024 * 1024; // 1MB limit

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $response['message'] = 'Upload error: ' . $file['error'];
            echo json_encode($response);
            exit;
        }

        if (!in_array($file['type'], $allowedTypes)) {
            $response['message'] = 'Only JPG, PNG, and PDF files allowed.';
            echo json_encode($response);
            exit;
        }

        if ($file['size'] > $maxFileSize) {
            $response['message'] = 'File size exceeds 1MB.';
            echo json_encode($response);
            exit;
        }

        if (!is_uploaded_file($file['tmp_name'])) {
            $response['message'] = 'Temporary file not found.';
            echo json_encode($response);
            exit;
        }

        // Get extension and generate completely new file name
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $uniqueFileName = 'visiting_card_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $extension; // New random filename
        $targetFilePath = $uploadDir . $uniqueFileName;

        if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
            $response['file_upload'] = 'success';
            $goForward = true;
        } else {
            $response['file_upload'] = 'error';
            $goForward = false;
            //echo json_encode( $response);

            if (file_exists($targetFilePath)) {
                unlink($targetFilePath); // Safely remove the uploaded file
            }
        }

    }


    if ($goForward === true) {
        switch ($postmodule) {
            case 'client':
            $parentType = 'C';
            break;
            case 'thirdparty':
            $parentType = 'TP';
            break;
            case 'legalfirm':
            $parentType = 'LF';
            break;
            case 'debtcollector':
            $parentType = 'DC';
            break;
            case 'activelegal':
            $parentType = 'AL';
            break;
        }
        $input_data['parent_id'] = $parentID;
        $input_data['parent_type'] = $parentType;
        $input_data['name'] = $contactName;
        $input_data['contact_number'] = $contact_number;
        $input_data['email'] = $email;
        $input_data['profession'] = $profession;
        $input_data['visiting_card'] = $uniqueFileName;
        $input_data['create_by'] = $_SESSION['LOGIN_LEGAL_ID'];
        $input_data['create_on'] = date('Y-m-d H:i:s');
        if($ObjContact->manage_contact($input_data)){
            $response['file_name'] = $uniqueFileName; // Return new filename if needed
            $response['status'] = 'success';
            $response['message'] = 'Contact added successfully.';
        }else{
            $response['status'] = 'error';
            $response['message'] = 'Error : Please try again.';
        }

        echo json_encode($response);
    } else if ($goForward !== true) {
        if ($response['file_upload'] == 'error') {
            $response['status'] = 'error';
            $response['message'] = 'Failed to save uploaded file.';
            echo json_encode($response);
        }
    }

}