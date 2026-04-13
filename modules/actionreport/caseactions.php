<?php
ob_start();
session_start();
# including files here
include_once("lib/config.php");
include_once("lib/class/class.dbcon.php");

if (LEGAL_AUTH_VIEW == false) {
    header("Location: " . ROOT_DIR . "permission_denied.php");
    exit();
}



$body = "caseactions.tpl";