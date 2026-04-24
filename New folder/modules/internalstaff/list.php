<?php
// ✅ Set page key BEFORE including the auth/permission file
$_REQUEST['page'] = 'internalstaff'; // Must match pageMenuMap key exactly

// Then include your auth file (wherever it's included)
// include_once("auth.php"); // your auth file

// ========================================================
// ✅ Check permission after auth file runs
// ========================================================
if (!defined('LEGAL_AUTH_VIEW') || LEGAL_AUTH_VIEW === false) {
    header("Location: " . ROOT_DIR . "permission_denied.php");
    exit();
}

$actve_sub_menu = 'dashboard';
$body = "list.tpl";
?>