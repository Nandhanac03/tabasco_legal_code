<?php
ob_start();
session_start();
# including files here
include_once("lib/config.php");
include_once("lib/class/class.dbcon.php");
include_once("lib/class/class.legal_case_notification.php");


$objActiveLegal = new Casenotification();
if($_SESSION['LOGIN_AGENCIES']==1){
    header("location: " . ROOT_DIR . "dashboard/agencies.html");
    exit;
}
$case_notification =  $objActiveLegal->get_notifications();

// echo '<pre>';
// print_r($case_notification);
// exit;

$body   =   "list.tpl";