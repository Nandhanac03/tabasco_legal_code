<?php
ob_start();
session_start();

include_once("lib/config.php");
include_once("lib/class/class.dbcon.php");
include_once("lib/class/class.common.php");
include_once("lib/class/class.legal_activity_log.php"); // make sure path is correct

// Create the logger object
$activityLog = new LegalActivityLog();

// Log logout only if user is logged in
if (!empty($_SESSION['LOGIN_LEGAL_ID'])) {
    $activityLog->logActivity(
        'LOGOUT',
        'User Logout',
        $_SESSION['LOGIN_LEGAL_ID'],
        "User {$_SESSION['LOGIN_LEGAL_NAME']} logged out from IP {$_SERVER['REMOTE_ADDR']}"
    );
}

// Destroy session
session_unset();
session_destroy();

// Redirect to login page
header("Location: " . ROOT_DIR . "login.php");
exit;
