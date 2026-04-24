<?php
if (LEGAL_AUTH_VIEW==false){
    header("Location: ".ROOT_DIR."permission_denied.php");
    exit();
}

$main_menu      =   'master';

$actve_sub_menu =   'lawyer';

$body           =   "lawyer.tpl";