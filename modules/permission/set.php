<?php
include_once("lib/class/class.legal_permission.php");
$ObjuserPermission = new userPermission();

$edit_id        =   trim($_GET['param1']);
$action         =   trim($_GET['action']);

if(!$edit_id){
    header("location: " . ROOT_DIR . "permission_denied.php");
    exit;
}


$array_UserData = $ObjuserPermission->get_legal_users($edit_id)[0];

$array_legal_menu = $ObjuserPermission->get_legal_menu();

// ✅ Corrected to load permissions for the user being edited
$array_allowed_permission = $ObjuserPermission->get_allowed_permission($edit_id);

// ✅ Build menu_id => actions map
$menu_permissions = [];
if (!empty($array_allowed_permission)) {
    foreach ($array_allowed_permission as $item) {
        $menu_permissions[$item['menu_id']] = explode(',', $item['actions']);
    }
}



$main_menu      =   'settings';
$actve_sub_menu =   'permission';
$body           =   "set.tpl";