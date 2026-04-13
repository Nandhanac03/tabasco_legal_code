<?php
ob_start();
session_start();
# including files here
include_once("lib/config.php");
include_once("lib/class/class.dbcon.php");
include_once("lib/class/class.legal_case_notification.php");


$objActiveLegal = new Casenotification();
if ($_SESSION['LOGIN_AGENCIES'] == 1) {
    header("location: " . ROOT_DIR . "dashboard/agencies.html");
    exit;
}
$case_notification =  $objActiveLegal->get_notifications();

include_once("lib/class/class.legal_task_reminders.php");
$objTask_reminders = new LegalTask_reminders();
$filter = [];
$filter['user_legal_id']       = trim($_SESSION['LOGIN_LEGAL_ID'] ?? '');
$filter['user_legal_type_id']  = trim($_SESSION['LOGIN_LEGAL_TYPE_ID'] ?? '');
$filter['user_legal_type']     = trim($_SESSION['LOGIN_LEGAL_TYPE'] ?? '');
$filter['super_admin']         = trim($_SESSION['LOGIN_SUPER_ADMIN'] ?? '');
$filter['active']              = 'A';
$filter['is_view']              = 'N';


$task_reminders =  $objTask_reminders->get_taskReminders($filter);



$actve_menu     = 'dashboard';
$actve_sub_menu = 'dashboard';
$body   =   "panel.tpl";
