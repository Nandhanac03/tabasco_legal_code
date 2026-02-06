<?php
ob_start();
session_start();
# including files here
include_once("lib/config.php");
include_once("lib/class/class.dbcon.php");
include_once("lib/class/class.legal_task_reminders.php");


$objTask_reminders = new LegalTask_reminders();
$filter = [];
$filter['user_legal_id']       = trim($_SESSION['LOGIN_LEGAL_ID'] ?? '');
$filter['user_legal_type_id']  = trim($_SESSION['LOGIN_LEGAL_TYPE_ID'] ?? '');
$filter['user_legal_type']     = trim($_SESSION['LOGIN_LEGAL_TYPE'] ?? '');
$filter['super_admin']         = trim($_SESSION['LOGIN_SUPER_ADMIN'] ?? '');
$filter['active']              = 'A';

$task_reminders =  $objTask_reminders->get_taskReminders($filter);

// echo '<pre>';
// print_r($result);
// exit;


$body   =   "list.tpl";
