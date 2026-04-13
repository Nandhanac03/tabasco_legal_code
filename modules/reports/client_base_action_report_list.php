<?php
ob_start();
session_start();
if (LEGAL_AUTH_VIEW==false){
    header("Location: ".ROOT_DIR."permission_denied.php");
    exit();
}
# including files here
include_once("lib/config.php");
include_once("lib/class/class.dbcon.php");
$actve_sub_menu =   'client_base_action_report_list';
$body = "client_base_action_report_list.tpl";