<?php
include_once("lib/class/class.legal_permission.php");
$ObjuserPermission = new userPermission();


$array_Userlist =   [];
$array_Userlist =   $ObjuserPermission->get_legal_users(0,'','','Y');


$main_menu      =   'settings';
$actve_sub_menu =   'permission';
$body           =   "userlist.tpl";