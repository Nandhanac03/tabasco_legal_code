<?php
ob_start();
include_once("lib/class/auth.php");
session_start();
if (LEGAL_AUTH_VIEW==false){
    header("Location: ".ROOT_DIR."permission_denied.php");
    exit();
}
# including files here
include_once("lib/config.php");
include_once("lib/class/class.dbcon.php");
$actve_sub_menu =   'action_report_list';
$body = "action_report_list.tpl";