<?php

ob_start();
session_start();
error_reporting(0);
include_once("../../../lib/config.php");
include_once("../../../lib/class/class.dbcon.php");
include_once("../../../lib/class/class.legal_task_reminders.php");
$objTask_reminders = new LegalTask_reminders();


if ($_POST['action'] == 'hide_task' && !empty($_POST['id'])) { 

    $data = array();
    $data['is_view'] = 'Y';
    $data['updated_by'] = $_SESSION['LOGIN_LEGAL_ID'];
    $data['updated_at'] = date('Y-m-d H:i:s');

    $result =  $objTask_reminders->save_taskReminders(['is_view' => 'Y'], $_POST['id']);
    if ($result == 1) {
        echo "success";
    } else {
        echo "error";
    }

    exit;
 }