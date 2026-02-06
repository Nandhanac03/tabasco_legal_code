<?php
ob_start();
session_start();
# including files here
include_once("lib/config.php");
include_once("lib/class/class.dbcon.php");
$actve_sub_menu =   'client_base_action';
$body = "client_base_action_report_list.tpl";