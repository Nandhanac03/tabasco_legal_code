<?php
header('Content-Type: application/json');
error_reporting(0);
ini_set('display_errors', 1);
session_start();

include_once("../../../lib/config.php");
include_once("../../../lib/class/class.dbcon.php");
include_once("../../../lib/class/class.legal_case.php");
include_once("../../../lib/class/class.legal_court.php");
include_once("../../../lib/class/class.legal_category.php");
$objLegalCase =   new LegalCase();

function generateCasesTemplate($data)
{
    $msg = '';
    if (empty($data)) {
        $msg = "<tr>
                    <td colspan='9' class='text-center'>No case available.</td>
                </tr>";
    } else {
        foreach ($data as $key => $case) {
            $sl = $key + 1;
            $msg .= "<tr>
                        <td>
                            <span class='text-inverse'>{$case['case_number']}</span><br>
                        </td>
                        <td class='text-center'>{$case['case_mode']}</td>
                        <td class='text-center'>{$case['register_date']}</td>
                        <td class='text-center'>{$case['total_outstanding']}</td>
                        <td class='text-center'>Pending</td>
                        <td class='text-center'>
                            <h4>
                            <a href='" . ROOT_DIR . " case/view/view/{$case['id']}.html' class='text-dark'>
                                <ion-icon name='eye-outline' onclick='window.location.href='" . ROOT_DIR . "case/view.html';'></ion-icon>
                            </a>
                            <a href='" . ROOT_DIR . "case/information/edit/{$case['id']}.html' class='text-dark'>
                                <ion-icon name='pencil-outline'></ion-icon>
                            </a>
                            <a href='javascript:void();' class='text-dark delete_case_btn'
                                data-id='{$case['id']}'
                                data-case_no='{$case['case_number']}'
                                data-active_legal_id='{$case['active_legal_id']}'
                                data-bs-toggle='modal' data-bs-target='#deleteModal'>
                                <ion-icon name='trash-outline'></ion-icon>
                            </a>
                            </h4>
                        </td>
                    </tr>";
        }
    }
    return $msg;
}


if ($_POST['action']) {
    $action = $_POST['action'];
    switch ($action) {
        case 'delete':
            // echo 'wrlong';
            // exit;
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                echo json_encode(['success' => false, 'message' => 'Invalid CSRF token.']);
                exit;
            }
            $case_id = isset($_POST['id']) ? $_POST['id'] : '';
            $active_legal_id = $_POST['active_legal_id'];

            $input_data = [];
            $input_data['id'] = $case_id;
            // $input_data['active_legal_id'] = $active_legal_id;
            $input_data['updated_on'] = date('Y-m-d H:i:s');
            $input_data['updated_id'] = $_SESSION['LOGIN_LEGAL_ID'];
            $input_data['status'] = 'A';
            if ($objLegalCase->disable_case($input_data, $case_id)) {
                $cases = $objLegalCase->get_case('', $active_legal_id);
                $html = generateCasesTemplate($cases);
                echo json_encode(['success' => true, 'message' => 'Deleted successfully', 'html' => $html]);
                exit;
            } else {
                echo json_encode(['success' => false, 'message' => 'Error occured while deleting.']);
                exit;
            }
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}
