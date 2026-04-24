<?php

ob_clean(); // Clears output buffer

header('Content-Type: application/json');

session_start();

error_reporting(0); // Prevents PHP notices/warnings from corrupting JSON

// ob_start();

include_once("../../../lib/config.php");

include_once("../../../lib/class/class.dbcon.php");

include_once("../../../lib/class/class.legal_location.php");
include_once("../../../lib/auth_ajax.php");

$objLocation =   new Location();




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

        $name = $_POST['location'] ?? '';

        $id = $_POST['id'] ?? '';

        $notId = $_POST['notId'] ?? '';

        if ($name == '') {

            echo json_encode(['success' => false, 'msg' => 'Title required']);

            exit;
        }

        try {

            $exist = $objLocation->get_location($id, $name, $notId);

            if ($exist) {

                echo json_encode(['success' => false, 'msg' => 'Location already exist.']);

                exit;
            } else {

                echo json_encode(['success' => true, 'msg' => 'Location not exist.']);

                exit;
            }
        } catch (Exception $e) {

            echo json_encode(['success' => false, 'msg' => $e->getMessage()]);

            exit;
        }

        break;

    case 'saveLocation':

        $title = $_POST['location'] ?? '';

        $id = $_POST['id'] ?? '';

        $user_id = $_SESSION['LOGIN_LEGAL_ID'];

        $data = [];

        if ($title == '') {

            echo json_encode(['success' => false, 'msg' => 'Title is required']);

            exit;
        }

        if (!$id) {

            $data['created_by'] = $user_id;

            $data['created_on'] = date('Y-m-d H:i:s');
        }

        $data['title'] = $title;

        $data['status'] = 'A';

        $data['updated_by'] = $user_id;

        $data['updated_on'] = date('Y-m-d H:i:s');

        // echo"<pre>";print_r($data);echo $id;exit;

        $locationSaved = $objLocation->save_location($data, $id);

        if ($locationSaved) {

            if ($id) {

                $response_xml = feedbackMsg(true, 'Location updated successfully.');
            } else {

                $response_xml = feedbackMsg(true, 'Location saved successfully.');
            }

            echo json_encode(['success' => true, 'msg' => 'Location saved successfully.', 'response_xml' => $response_xml]);

            exit;
        } else {

            $response_xml = feedbackMsg(false, 'Error occured while saving.');

            echo json_encode(['success' => false, 'msg' => 'Error occured while saving.', 'response_xml' => $response_xml]);

            exit;
        }

        break;

    case 'locationListing':

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

        $locations = $objLocation->get_location('', '', '', $search, $limit, $offset);

        $location_count = $objLocation->get_location('', '', '', $search);

        $location_count = empty($location_count) ? 0 : count($location_count);

        if (!empty($locations)) {

            foreach ($locations as $key => $location) {

                $slNo = $offset + ($key + 1);

                $list .= "  <tr>

                                <td>$slNo.</td>

                                <td>{$location['title']}</td>

                                <td>

                                    <div class='btn-group'>";

                if (defined('LEGAL_AUTH_EDIT') && LEGAL_AUTH_EDIT) {
                    $list .= "

                                        <button type='button' class='btn btn-warning' title='Edit'

                                            data-bs-toggle='modal' data-bs-target='#editModal' data-location_title='{$location['title']}' data-location_id='{$location['id']}'>

                                            <i class='fadeIn animated bx bx-pencil'></i></button>";
                }

                if (defined('LEGAL_AUTH_DELETE') && LEGAL_AUTH_DELETE) {
                    $list .= "

                                        <button type='button' class='btn btn-danger' title='Delete'

                                            data-bs-toggle='modal' data-bs-target='#deleteModal' data-location_title='{$location['title']}' data-location_id='{$location['id']}'>

                                            <i class='lni lni-trash'></i></button>";
                }

                $list .= "    

                                    </div>

                                </td>

                            </tr>";
            }
        } else {

            $list .= "<tr><td colspan='3' style='text-align:center;'>No Location available !</td></tr>";
        }

        // echo"<pre>";print_r($list);exit;

        echo json_encode(['success' => true, 'html' => $list, 'location_count' => $location_count]);

        // echo "<pre>";

        // print_r($banks);

        exit;

    case 'deleteLocation':

        $id = $_POST['id'];

        $data = [];

        $user_id = $_SESSION['LOGIN_LEGAL_ID'];



        $data['status'] = 'D';

        $data['updated_by'] = $user_id;

        $data['updated_on'] = date('Y-m-d H:i:s');

        $areaDisabled = $objLocation->disable_location($data, $id);

        if ($areaDisabled) {

            $response_xml = feedbackMsg(true, 'Location deleted successfully.');

            echo json_encode(['success' => true, 'msg' => $response_xml]);

            exit;
        } else {

            $response_xml = feedbackMsg(false, 'Error occured while deleting.');

            echo json_encode(['success' => false, 'msg' => $response_xml]);

            exit;
        }
}
