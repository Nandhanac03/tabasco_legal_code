<?php
ob_start();
session_start();
# including files here
include_once("lib/config.php");
include_once("lib/class/class.dbcon.php");
unset($_SESSION['LOGIN_SUPERADMIN_ID']);
unset($_SESSION['LOGIN_SUPERADMIN_NAME']);
unset($_SESSION['LOGIN_SUPERADMIN']);
unset($_SESSION['LOGIN_AUTHENTICATION_ID']);
unset($_SESSION['LOGIN_AUTHENTICATION_NAME']);
unset($_SESSION['LOGIN_DISTRIBUTOR_ID']);
unset($_SESSION['LOGIN_DISTRIBUTOR_NAME']);
unset($_SESSION['LOGIN_DISTRIBUTOR']);
header("location: ".ROOT_DIR."admin/login.html");
$body   =   "signout.tpl";
?>