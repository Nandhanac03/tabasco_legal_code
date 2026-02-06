<?php
ob_start();
session_start();
# including files here
include_once("lib/config.php");
include_once("lib/class/class.dbcon.php");

$edit_id = trim($_GET['param1']);
$action = trim($_GET['action']);

if (!$edit_id) {
    header("location: " . ROOT_DIR . "permission_denied.php");
    exit;
}
$activeLegalId = $_SESSION['ACTIVE_LEGAL_ID'];
// echo '<pre>';print_r($activeLegalId);exit;

$body   =   "hearing.tpl";