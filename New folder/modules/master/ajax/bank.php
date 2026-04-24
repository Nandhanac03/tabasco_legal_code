<?php

ob_clean(); // Clears output buffer

header('Content-Type: application/json');

session_start();

error_reporting(0); // Prevents PHP notices/warnings from corrupting JSON

// ob_start();

include_once("../../../lib/config.php");

include_once("../../../lib/class/class.dbcon.php");

include_once("../../../lib/class/class.legal_bank.php");
include_once("../../../lib/auth_ajax.php");

$objBank =   new bankDetails();



function feedbackMsg($success = false, $msg = "Error occured !")

{

    if ($success) {

        $response = "    <div class='alert alert-dismissible fade show py-2 border-0 border-start border-4 border-success mb-0'>

                        <div class='d-flex align-items-center'>

                            <div class='fs-3 text-success'><ion-icon name='checkmark-circle-sharp' role='img' class='md hydrated' aria-label='checkmark circle sharp'></ion-icon>

                            </div>

                            <div class='ms-3'>

                                <div class='text-success'>{$msg}</div>

                            </div>

                        </div>

                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>

                    </div>";
    } else {

        $response = "    <div class='alert alert-dismissible fade show py-2 border-0 border-start border-4 border-danger mb-0'>

                        <div class='d-flex align-items-center'>

                            <div class='fs-3 text-danger'><ion-icon name='close-circle-sharp' role='img' class='md hydrated' aria-label='checkmark circle sharp'></ion-icon>

                            </div>

                            <div class='ms-3'>

                                <div class='text-danger'>{$msg}</div>

                            </div>

                        </div>

                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>

                    </div>";
    }

    return $response;
}



$action = $_POST['method'] ?? '';



switch ($action) {

    case 'checkDuplicate':

        $name = $_POST['bank'] ?? '';

        $id = $_POST['id'] ?? '';

        $notId = $_POST['notId'] ?? '';

        if ($name == '') {

            echo json_encode(['success' => false, 'msg' => 'Title required']);

            exit;
        }

        try {

            $exist = $objBank->get_bank_names($id, $name, $notId);

            if ($exist) {

                echo json_encode(['success' => false, 'msg' => 'Bank name already exist.']);

                exit;
            } else {

                echo json_encode(['success' => true, 'msg' => 'Bank name not exist.']);

                exit;
            }
        } catch (Exception $e) {

            echo json_encode(['success' => false, 'msg' => $e->getMessage()]);

            exit;
        }

        break;

    case 'saveBank':

        $name = $_POST['bank'] ?? '';

        $id = $_POST['id'] ?? '';

        $user_id = $_SESSION['LOGIN_LEGAL_ID'];

        $data = [];

        if ($name == '') {

            echo json_encode(['success' => false, 'msg' => 'Name is required']);

            exit;
        }

        if (!$id) {

            $data['created_by'] = $user_id;

            $data['created_on'] = date('Y-m-d H:i:s');
        }

        $data['name'] = $name;

        $data['status'] = 'A';

        $data['updated_by'] = $user_id;

        $data['updated_on'] = date('Y-m-d H:i:s');

        $bankSaved = $objBank->save_bank($data, $id);

        if ($bankSaved) {

            if ($id) {

                $response_xml = feedbackMsg(true, 'Bank updated successfully.');
            } else {

                $response_xml = feedbackMsg(true, 'Bank saved successfully.');
            }

            echo json_encode(['success' => true, 'msg' => 'Bank saved successfully.', 'response_xml' => $response_xml]);

            exit;
        } else {

            echo json_encode(['success' => false, 'msg' => 'Error occured while saving.', 'response_xml' => $response_xml]);

            exit;
        }

        break;

    case 'bankListing':

        $search = $_POST['search'] ?? '';

        $limit = $_POST['pageNo'] ? $_POST['pageNo'] : 1;

        $offset = 0;

        $pagination_count = 10; //change pagination listing count here also in paginationCount in area.tpl

        if ($limit && $limit != '') {

            if ($limit > 1) {

                $offset = ($limit - 1) * $pagination_count;
            }
        }

        $limit = $limit * $pagination_count;

        $banks = $objBank->get_bank_names('', '', '', $search, $limit, $offset);

        $bank_count = $objBank->get_bank_names('', '', '', $search);

        $bank_count = empty($bank_count) ? 0 : count($bank_count);

        if (!empty($banks)) {

            foreach ($banks as $key => $bank) {

                $slNo = $offset + ($key + 1);

                $list .= "  <tr>

                                <td>$slNo.</td>

                                <td>{$bank['name']}</td>

                                <td>

                                    <div class='btn-group'>";

                if (defined('LEGAL_AUTH_EDIT') && LEGAL_AUTH_EDIT) {
                    $list .= "

                                        <button type='button' class='btn btn-warning' title='Edit'

                                            data-bs-toggle='modal' data-bs-target='#editModal' data-bank_name='{$bank['name']}' data-bank_id='{$bank['id']}'>

                                            <i class='fadeIn animated bx bx-pencil'></i></button>";
                }

                if (defined('LEGAL_AUTH_DELETE') && LEGAL_AUTH_DELETE) {
                    $list .= "

                                        <button type='button' class='btn btn-danger' title='Delete'

                                            data-bs-toggle='modal' data-bs-target='#deleteModal' data-bank_name='{$bank['name']}' data-bank_id='{$bank['id']}'>

                                            <i class='lni lni-trash'></i></button>";
                }

                $list .= "    

                                    </div>

                                </td>

                            </tr>";
            }
        } else {

            $list .= "<tr><td colspan='3' style='text-align:center;'>No Banks available !</td></tr>";
        }

        echo json_encode(['success' => true, 'html' => $list, 'bank_count' => $bank_count]);

        // echo "<pre>";

        // print_r($banks);

        exit;

    case 'deleteBank':

        $id = $_POST['id'];

        $data = [];

        $user_id = $_SESSION['LOGIN_LEGAL_ID'];



        $data['status'] = 'D';

        $data['updated_by'] = $user_id;

        $data['updated_on'] = date('Y-m-d H:i:s');

        $areaDisabled = $objBank->disable_bank($data, $id);

        if ($areaDisabled) {

            $response_xml = feedbackMsg(true, 'Bank deleted successfully.');

            echo json_encode(['success' => true, 'msg' => $response_xml]);

            exit;
        } else {

            $response_xml = feedbackMsg(false, 'Error occured while deleting.');

            echo json_encode(['success' => false, 'msg' => $response_xml]);

            exit;
        }
}
