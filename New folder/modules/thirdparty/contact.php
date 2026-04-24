<?php

$edit_id        =   trim($_GET['param1']);
$action         =   trim($_GET['action']);


if(!$edit_id){
    header("location: " . ROOT_DIR . "permission_denied.php");
    exit;
}

$actve_sub_menu = 'dashboard';
$body   =   "contact.tpl";