<?php

ob_end_clean(); // Discard all unwanted echo/print

header('Content-Type: application/json');

error_reporting(0);

ini_set('display_errors', 1);

session_start();



// Include necessary files

include_once("../lib/config.php");

include_once("../lib/class/class.dbcon.php");

include_once("../lib/class/class.legal_cheque.php");


include_once("../lib/class/class.legal_case.php");

$objLegalCase =   new LegalCase();

$objCheque = new Cheque();



if ($_POST) {




    $input_data = array();

    $uploadDir = '../uploads/all_cheque' . DIRECTORY_SEPARATOR;



    // CSRF token validation

    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {

        echo json_encode(['status' => 'error', 'message' => 'Invalid CSRF token.']);

        exit;
    }



    // Create directory if it doesn't exist

    if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {

        echo json_encode(['success' => false, 'status' => 'error', 'message' => 'Failed to create upload directory.']);

        exit;
    }



    $response = ['success' => false, 'message' => ''];



    // Hidden fields
    $postmodule  = isset($_POST['hid_module']) ? htmlspecialchars($_POST['hid_module']) : null;
    $postpage    = isset($_POST['hid_page']) ? htmlspecialchars($_POST['hid_page']) : null;
    $postID      = isset($_POST['hid_parentID']) ? htmlspecialchars($_POST['hid_parentID']) : null;

    // ✅ Prepare DB insert data

    switch ($postmodule) {
        case 'client':
            $parentType = 'C';
            $parentID      = isset($_POST['hid_parentID']) ? htmlspecialchars($_POST['hid_parentID']) : null;
            break;
        case 'case':
            $parentType = 'CA';
            $postID      = isset($_POST['hid_parentID']) ? htmlspecialchars($_POST['hid_parentID']) : null;
            if ($postID) {
                $case       =  $objLegalCase->get_case($postID);
                $parentID   =   $case[0]['client_id'];
            }
            break;
    }







    // Cheque fields

    $cheque_type   = isset($_POST['cheque_type']) ? htmlspecialchars($_POST['cheque_type']) : null;

    $cheque_date   = isset($_POST['cheque_date']) ? htmlspecialchars($_POST['cheque_date']) : null;

    $cheque_amount = isset($_POST['cheque_amount']) ? floatval($_POST['cheque_amount']) : null;

    $cheque_number = isset($_POST['cheque_number']) ? htmlspecialchars($_POST['cheque_number']) : null;
    $cheque_bank = isset($_POST['cheque_bank']) ? htmlspecialchars($_POST['cheque_bank']) : null;
    $cheque_bounced_date = !empty($_POST['cheque_bounced_date']) ? $_POST['cheque_bounced_date'] : null;





    // ✅ Validate required fields based on cheque_type

    if ($cheque_type == 1) {

        // If cheque_type=1, cheque_date, cheque_amount, file, and hidden fields are required
        if (!$cheque_date || !$cheque_amount || !$cheque_number|| !$cheque_bank || !isset($_FILES['cheque_file']) || !$postID || !$postmodule || !$postpage ) {

            $response['message'] = VALIDATION_MSG;

            $response['status'] = 'error';

            echo json_encode($response);

            exit;
        }
    } else {

        // If cheque_type!=1, only cheque_amount and hidden fields are required

        if (!$cheque_amount || !$postID || !$postmodule || !$postpage) {

            $response['message'] = VALIDATION_MSG;

            $response['status'] = 'error';

            echo json_encode($response);

            exit;
        }
    }







    $uniqueFileName = '';

    $targetFilePath = '';



    // ✅ Only process file upload if cheque_type == 1

    if ($cheque_type == 1) {

        $file = $_FILES['cheque_file'];

        $allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];

        $maxFileSize = 1 * 1024 * 1024; // 2MB limit



        if ($file['error'] !== UPLOAD_ERR_OK) {

            $response['message'] = 'Upload error: Please Upload any File';

            $response['status'] = 'error';

            echo json_encode($response);

            exit;
        }



        if (!in_array($file['type'], $allowedTypes)) {

            $response['message'] = 'Only JPG, PNG, and PDF files allowed.';

            $response['status'] = 'error';

            echo json_encode($response);

            exit;
        }



        if ($file['size'] > $maxFileSize) {

            $response['message'] = 'File size exceeds 2MB.';

            $response['status'] = 'error';

            echo json_encode($response);

            exit;
        }



        if (!is_uploaded_file($file['tmp_name'])) {

            $response['message'] = 'Temporary file not found.';

            $response['status'] = 'error';

            echo json_encode($response);

            exit;
        }



        // Generate new unique file name

        $extension      = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        $uniqueFileName = 'cheque_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $extension;

        $targetFilePath = $uploadDir . $uniqueFileName;



        // Move uploaded file

        if (!move_uploaded_file($file['tmp_name'], $targetFilePath)) {

            $response['success'] = false;

            $response['status'] = 'error';

            $response['message'] = 'Failed to save uploaded file.';

            echo json_encode($response);

            exit;
        }
    }



    // ✅ Fill data for DB

    $input_data['add_type']    = $cheque_type;

    $input_data['upload_date'] = ($cheque_type == 1) ? $cheque_date : date('Y-m-d'); // current date if not type=1

    $input_data['amount']      = $cheque_amount;

    $input_data['cheque_name'] = ($cheque_type == 1) ? $uniqueFileName : ''; // Empty for non-type=1

    $input_data['notes']       = '';

    $input_data['parent_id']   = $parentID;

    $input_data['type']        = $parentType;

    $input_data['create_by']   = $_SESSION['LOGIN_LEGAL_ID'];

    $input_data['create_on']   = date('Y-m-d H:i:s');

    $input_data['cheque_number']    = $cheque_number;
    $input_data['cheque_bank']    = $cheque_bank;
    $input_data['cheque_bounced_date']    = $cheque_bounced_date;




    // Save to DB

    if ($objCheque->upload_cheque($input_data)) {

        $response['success']   = true;

        $response['status']    = 'success';

        $response['message']   = 'Cheque details added successfully!';

        $response['file_name'] = $uniqueFileName;

       // $objlogger->logActivity('CREATE', 'Cheque', null, "Added cheque of amount {$cheque_amount} for parent ID: {$parentID} ({$parentType})", null, $input_data);
    } else {

        $response['success'] = false;

        $response['status']  = 'error';

        $response['message'] = 'Failed to save uploaded file.';



        // If file was uploaded but DB save failed, delete it

        if ($cheque_type == 1 && $uniqueFileName && file_exists($targetFilePath)) {

            unlink($targetFilePath);
        }
    }



    echo json_encode($response);
}
