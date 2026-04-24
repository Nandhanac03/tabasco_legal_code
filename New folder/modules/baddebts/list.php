<?php
include_once("lib/auth.php");
if (LEGAL_AUTH_VIEW==false){
    header("Location: ".ROOT_DIR."permission_denied.php");
    exit();
}
ob_start();
session_start();
# including files here
include_once("lib/config.php");
include_once("lib/class/class.dbcon.php");
include_once("lib/class/class.legal_common_selection.php");

$objCommonSelection = new CommonSelection();

$array_users = array();

$array_users = $objCommonSelection->get_all_users('yes', '21,1');

$array_legal_client_marketing    =   array();
$array_legal_client_marketing    =   $objCommonSelection->get_marketing_legal_client();



$body   =   "list.tpl";