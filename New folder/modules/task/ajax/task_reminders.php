<?php

ob_start();

session_start();

error_reporting(0);



include_once("../../../lib/config.php");

include_once("../../../lib/class/class.dbcon.php");
include_once("../../../lib/class/class.legal_task_reminders.php");


$objTask_reminders = new LegalTask_reminders();

if ($_POST) {
    $task_name     = trim($_POST['task_name'] ?? '');
    $task_info     = trim($_POST['task_info'] ?? '');
    $task_date     = trim($_POST['task_date'] ?? '');
    $hearing_date     = trim($_POST['hearing_date'] ?? '');
    $task_remindfrom     = trim($_POST['task_remindfrom'] ?? '');
    $status     = trim($_POST['status'] ?? '');

    $filter = [];
    $filter['user_legal_id']       = trim($_SESSION['LOGIN_LEGAL_ID'] ?? '');
    $filter['user_legal_type_id']  = trim($_SESSION['LOGIN_LEGAL_TYPE_ID'] ?? '');
    $filter['user_legal_type']     = trim($_SESSION['LOGIN_LEGAL_TYPE'] ?? '');
    $filter['super_admin']         = trim($_SESSION['LOGIN_SUPER_ADMIN'] ?? '');
    $filter['task_name']           = $task_name;
    $filter['task_info']           = $task_info;
    $filter['task_date']           = $task_date;
    $filter['reminder_date']       = $task_remindfrom;
    $filter['status']              = $status;

    $filter['created_at']          = date('Y-m-d H:i:s');
    $filter['created_by']          = $_SESSION['LOGIN_LEGAL_ID'];

    $filter['updated_at']          = date('Y-m-d H:i:s');
    $filter['updated_by']          = $_SESSION['LOGIN_LEGAL_ID'];

    $filter['active']              = 'A';

    $result =  $objTask_reminders->save_taskReminders($filter);


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
