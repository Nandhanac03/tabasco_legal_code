<?php
ob_start();
session_start();
# including files here
include_once("lib/config.php");
include_once("lib/class/class.dbcon.php");
$actve_sub_menu =   'expense_report';
$body = "expense_report_list.tpl";