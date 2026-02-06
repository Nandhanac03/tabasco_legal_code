<?php
ob_start();
session_start();
# including files here
include_once("lib/config.php");
include_once("lib/class/class.dbcon.php");



$main_menu      =   'settings';
$actve_sub_menu =   'profile';
$body           =   "profile.tpl";