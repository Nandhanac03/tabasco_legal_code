<?php
ob_start();
session_start();
// echo"<pre>";
// print_r($_SESSION);
// exit();
if (LEGAL_AUTH_VIEW==false){
    header("Location: ".ROOT_DIR."permission_denied.php");
    exit();
}
# including files here
include_once("lib/config.php");
include_once("lib/class/class.dbcon.php");
$actve_sub_menu =   'case_report_list';
$body = "case_report_list.tpl";