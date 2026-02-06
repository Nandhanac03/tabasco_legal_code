<?php

ob_start();

session_start();

error_reporting(0);



include_once("../../../lib/config.php");
include_once("../../../lib/class/class.dbcon.php");
include_once("../../../lib/class/class.legal_case_notification.php");
include_once("../../../lib/class/class.legal_case_hearing.php");
$objCaseHearing = new CaseHearing();


$objActiveLegal = new Casenotification();

if ($_POST) {
    // echo '<pre>';
    // print_r($_POST);
    // exit;
    $marketing     = trim($_POST['marketing'] ?? '');
    $client     = trim($_POST['client'] ?? '');
    $case     = trim($_POST['case'] ?? '');
    $hearing_date     = trim($_POST['hearing_date'] ?? '');
    $remind_date     = trim($_POST['remind_date'] ?? '');
    $case_status     = trim($_POST['status'] ?? '');
    $active_legal_id     = trim($_POST['active_legal_id'] ?? '');
    $case_root_id     = trim($_POST['stage'] ?? '');

    $filter = [];
    $filter['active_legal_id'] = $active_legal_id;
    $filter['case_id'] = $case;
    $filter['client_id'] = $client;
    $filter['marketing_id'] = $marketing;
    $filter['hearing_date'] = $hearing_date;
    $filter['remind_date'] = $remind_date;
    $filter['case_status'] = $case_status;
    $filter['case_root_id'] = $case_root_id;

    $filter['created_at'] = date('Y-m-d H:i:s');
    $filter['created_by'] = $_SESSION['LOGIN_LEGAL_ID'];
    $result =  $objActiveLegal->save_notification($filter);

    $input_data = array();

    $input_data['case_id']               = $case;
    $input_data['hearing_date']          = $hearing_date;
    $input_data['created_on']            = date('Y-m-d H:i:s');
    $input_data['created_id']            = $_SESSION['LOGIN_LEGAL_ID'];
    $input_data['status']                = 'A';
    $objCaseHearing->save_hearing($input_data);


    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'Notification saved successfully'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to save notification'
        ]);
    }
    exit;
}
