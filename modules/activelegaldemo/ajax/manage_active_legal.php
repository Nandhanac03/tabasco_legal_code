<?php
ob_start();
session_start();
error_reporting(0);

include_once("../../../lib/config.php");
include_once("../../../lib/class/class.dbcon.php");
include_once("../../../lib/class/class.legal_active_legals.php");
$objActiveLegal = new ActiveLegal();


if ($_POST) {
    $action = $_POST['action'];
    if ($action) {
        $user_id = $_SESSION['LOGIN_LEGAL_ID'];
        switch ($action) {
            case 'deleteActiveLegal':
                $id = $_POST['id'];
                if (!$id) {
                    echo json_encode(['success' => false, 'message' => 'Id required']);
                    exit;
                }
                $filters = [
                    'id' => $id,
                    'status' => 'A',
                ];
                $current_active_legal = $objActiveLegal->Get_ActiveLegal_Information($filters);
                if (empty($current_active_legal)) {
                    echo json_encode(['success' => false, 'message' => 'Data not exist']);
                    exit;
                }
                $input_data = [];
                $input_data['status'] = 'D';
                $input_data['updated_id'] = $user_id;
                $input_data['updated_on'] = date('Y-m-d H:i:s');

                if ($objActiveLegal->disable_active_legal($input_data, $id)) {
                    echo json_encode(['success' => true, 'message' => 'Data Deleted successfully.']);
                    exit;
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error occured while deleting.']);
                    exit;
                }
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Action required']);
        exit;
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Unauthorized request']);
    exit;
}
