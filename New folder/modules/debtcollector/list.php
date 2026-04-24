<?php
if (LEGAL_AUTH_VIEW==false){
    header("Location: ".ROOT_DIR."permission_denied.php");
    exit();
}
$actve_sub_menu = 'dashboard';

$body = "list.tpl";