<?php
ob_start();
session_start();
# including files here
include_once("lib/config.php");
include_once("lib/class/class.dbcon.php");


        // switch($_SESSION['LOGIN_LEGAL_TYPE_ID']){
        //   case 'TP':
        //     header("location: " . ROOT_DIR . "thirdparty/view/info/" . intval($_SESSION['LOGIN_LEGAL_ID']) . '.html');
        //   break;
        //    case 'LF':
        //   break;
        //   case 'DC':
        //   break;
        // }

$actve_menu     = 'dashboard';
$actve_sub_menu = 'dashboard';
$body   =   "agencies.tpl";