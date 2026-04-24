<?php

$_REQUEST['page'] = 'legalteam'; // Must match pageMenuMap key exactly

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