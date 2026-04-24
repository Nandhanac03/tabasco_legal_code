<?php

header('Content-Type: application/json');

error_reporting(0);

ini_set('display_errors', 1);

session_start();



include_once("../../../lib/config.php");

include_once("../../../lib/class/class.dbcon.php");

include_once("../../../lib/class/class.legal_case_hearing.php");



$objCaseHearing = new CaseHearing();





function load_hearing_template($data)

{

    $tmpl = '';

    if (empty($data)) {

        $tmpl = " <tr>

            <td class='text-center' colspan='5'>No data available...</td>

        </tr>";
    } else {

        foreach ($data as $key => $each_data) {

            $no = $key + 1;

               // Get the full feedback
    $full_feedback = $each_data['hearing_feedback'];

    // Create the 20-character version for default display
    $short_feedback = (mb_strlen($full_feedback) > 20) 
                      ? mb_substr($full_feedback, 0, 20) . "..." 
                      : $full_feedback;

            $tmpl .= "<tr>
                <td>{$no}</td>
                <td>{$each_data['hearing_date']}</td>
                <td>{$each_data['hearing_feedback_date']}</td>
    <td style='max-width:150px; min-width:150px; position: relative; vertical-align: top;'>
    <div class='hover-container'>
           <div class='text-box' style='white-space: nowrap; overflow: hidden; text-overflow: ellipsis;'>  {$short_feedback}</div>
        
             <div class='full-content-tooltip'>" . htmlspecialchars($full_feedback) . "</div>
                </div>
        </td>";
            // File column
            if (!empty($each_data['file'])) {
                $tmpl .= "<td>
                    <a href='" . ROOT_DIR . "/uploads/hearing_files/{$each_data['file']}' target='_blank'>View</a>
                </td>";
            } else {
                $tmpl .= "<td>No File</td>";
            }

            
        }
    }

    return $tmpl;
}





if ($_POST) {



    $duty = $_POST['duty'];

    switch ($duty) {



        case 'save':

            $uploadDir = realpath(__DIR__ . '/../../../uploads/hearing_files/') . DIRECTORY_SEPARATOR;



            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {

                echo json_encode(['success' => false, 'message' => 'Invalid CSRF token.', 'file_error' => false]);

                exit;
            }



            $case_id = isset($_POST['case_id']) ? $_POST['case_id'] : '';

            $hearing_date = isset($_POST['hearing_date']) ? $_POST['hearing_date'] : '';

            $hearing_feedback_date = isset($_POST['hearing_feedback_date']) ? $_POST['hearing_feedback_date'] : '';

            $hearing_feedback = isset($_POST['hearing_feedback']) ? $_POST['hearing_feedback'] : '';



            if (!$case_id || !$hearing_date || !$hearing_feedback_date || !$hearing_feedback) {

                echo json_encode(['success' => false, 'message' => VALIDATION_MSG, 'file_error' => false]);

                exit;
            }

            // File upload validation

            $file = $_FILES['hearing_file'];

            $allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];

            $maxFileSize = 1 * 1024 * 1024; // 2MB limit
            $uniqueFileName = '';
            if (isset($file)) {

                if ($file['error'] !== UPLOAD_ERR_OK) {
                    echo json_encode(['success' => false, 'message' => 'Upload error: Please Upload any File', 'file_error' => true]);
                    exit;
                }

                if (!in_array($file['type'], $allowedTypes)) {
                    echo json_encode(['success' => false, 'message' => 'Only JPG, PNG, and PDF files allowed.', 'file_error' => true]);
                    exit;
                }

                if ($file['size'] > $maxFileSize) {
                    echo json_encode(['success' => false, 'message' => 'File size exceeds 2MB.', 'file_error' => true]);
                    exit;
                }

                if (!is_uploaded_file($file['tmp_name'])) {
                    echo json_encode(['success' => false, 'message' => 'Temporary file not found.', 'file_error' => true]);
                    exit;
                }

                if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
                    echo json_encode(['success' => false, 'message' => 'Directory not found.', 'file_error' => false]);
                    exit;
                }

                $extension          = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                $uniqueFileName     = 'filez_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $extension; // New random filename
                $targetFilePath     = $uploadDir . $uniqueFileName;
            }

            $input_data = array();

            $input_data['case_id']               = $case_id;
            $input_data['hearing_date']          = $hearing_date;
            $input_data['hearing_feedback_date'] = $hearing_feedback_date;
            $input_data['hearing_feedback']      = $hearing_feedback;
            $input_data['created_on']            = date('Y-m-d H:i:s');
            $input_data['created_id']            = $_SESSION['LOGIN_LEGAL_ID'];
            $input_data['status']                = 'A';

            if (!empty($file['name'])) {

                if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
                    $input_data['file'] = $uniqueFileName;
                } else {
                    echo json_encode([
                        'success' => false,
                        'message' => 'File upload failed.'
                    ]);
                    exit;
                }
            } else {
                $input_data['file'] = null;
            }

            if ($objCaseHearing->save_hearing($input_data)) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Saved successfully!'
                ]);
                exit;
            } else {

                if (!empty($input_data['file']) && file_exists($targetFilePath)) {
                    unlink($targetFilePath);
                }

                echo json_encode([
                    'success' => false,
                    'message' => 'Failed to save.'
                ]);
                exit;
            }



            // if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {

            //     $input_data =  array();

            //     $input_data['case_id']                  =  $case_id;

            //     $input_data['file']                     =  $uniqueFileName; // Return new filename if needed

            //     $input_data['hearing_date']             =  $hearing_date;

            //     $input_data['hearing_feedback_date']    =  $hearing_feedback_date;

            //     $input_data['hearing_feedback']         =  $hearing_feedback;

            //     $input_data['created_on']                =  date('Y-m-d H:i:s');

            //     $input_data['created_id']                =  $_SESSION['LOGIN_LEGAL_ID'];

            //     $input_data['status']                   =  'A';



            //     if ($objCaseHearing->save_hearing($input_data)) {

            //         echo json_encode(['success' => true, 'message' => 'Saved successfully!']);

            //         exit;
            //     } else {

            //         // ❌ Failed to save document data, so unlink (delete) the uploaded file

            //         if (file_exists($targetFilePath)) {

            //             unlink($targetFilePath); // Safely remove the uploaded file

            //         }

            //         echo json_encode(['success' => false, 'message' => 'Failed to save.']);

            //         exit;
            //     }
            // } else {

            //     echo json_encode(['success' => false, 'msg' => 'Failed to upload file.']);

            //     exit;
            // }

        case 'load_hearing':

            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {

                echo json_encode(['success' => false, 'message' => 'Invalid CSRF token.']);

                exit;
            }

            $case_id = isset($_POST['case_id']) ? $_POST['case_id'] : '';

            $hearings = $objCaseHearing->get_hearing('', $case_id);

            echo json_encode(['success' => true, 'message' => load_hearing_template($hearings)]);

            exit;

        case 'get_hearing':

            if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                echo json_encode(['success' => false, 'message' => 'Invalid CSRF token']);
                exit;
            }

            $id = $_POST['id'];
            $data = $objCaseHearing->get_hearing($id, '');

            if ($data) {
                echo json_encode(['success' => true, 'data' => $data[0]]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Data not found']);
            }
            exit;

        case 'update_hearing':

            if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                echo json_encode(['success' => false, 'message' => 'Invalid CSRF token']);
                exit;
            }

            $id = $_POST['id'];

            $input_data = [
                'hearing_date' => $_POST['hearing_date'],
                'hearing_feedback_date' => $_POST['hearing_feedback_date'],
                'hearing_feedback' => $_POST['hearing_feedback'],
                'updated_on' => date('Y-m-d H:i:s'),
                'updated_id' => $_SESSION['LOGIN_LEGAL_ID']
            ];

            /* ========= FILE UPLOAD (EDIT) ========= */
            if (!empty($_FILES['hearing_file']['name'])) {

                $uploadDir = realpath(__DIR__ . '/../../../uploads/hearing_files/') . DIRECTORY_SEPARATOR;
                $file = $_FILES['hearing_file'];

                $allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
                $maxFileSize = 1 * 1024 * 1024;

                if ($file['error'] !== UPLOAD_ERR_OK) {
                    echo json_encode(['success' => false, 'message' => 'File upload error']);
                    exit;
                }

                if (!in_array($file['type'], $allowedTypes)) {
                    echo json_encode(['success' => false, 'message' => 'Invalid file type']);
                    exit;
                }

                if ($file['size'] > $maxFileSize) {
                    echo json_encode(['success' => false, 'message' => 'File size exceeds limit']);
                    exit;
                }

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                $old = $objCaseHearing->get_hearing($id, '');
                if (!empty($old[0]['file'])) {
                    @unlink($uploadDir . $old[0]['file']);
                }

                $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                $uniqueFileName = 'filez_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $extension;
                $targetFilePath = $uploadDir . $uniqueFileName;

                if (!move_uploaded_file($file['tmp_name'], $targetFilePath)) {
                    echo json_encode(['success' => false, 'message' => 'File upload failed']);
                    exit;
                }

                


                // ✅ only now set file
                $input_data['file'] = $uniqueFileName;
            }

            if ($objCaseHearing->save_hearing($input_data, $id)) {
                echo json_encode(['success' => true, 'message' => 'Updated successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Update failed']);
            }
            exit;




        case 'delete_hearing':

            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {

                echo json_encode(['success' => false, 'message' => 'Invalid CSRF token.']);

                exit;
            }

            $id = isset($_POST['delete_id']) ? $_POST['delete_id'] : '';

            $case_id = isset($_POST['case_id']) ? $_POST['case_id'] : '';

            if ($objCaseHearing->get_hearing($id, $case_id)) {

                $input_data = array();

                $input_data['status'] = 'D';

                $input_data['updated_on'] = date('Y-m-d H:i:s');

                $input_data['updated_id'] = $_SESSION['LOGIN_LEGAL_ID'];

                if ($objCaseHearing->delete_hearing($input_data, $id)) {

                    echo json_encode(['success' => true, 'message' => 'Data deleted successfully.']);

                    exit;
                } else {

                    echo json_encode(['success' => false, 'message' => 'Failed to delete data.']);

                    exit;
                }
            } else {

                echo json_encode(['success' => false, 'message' => 'No data found for deletion.']);

                exit;
            }

        default:

            echo json_encode(['success' => false, 'message' => 'Invalid request.']);

            exit;
    }
} else {

    echo json_encode(['success' => false, 'msg' => 'Permission denied']);

    exit;
}
