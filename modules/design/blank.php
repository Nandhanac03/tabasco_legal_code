<?php
ob_start();
session_start();
# including files here
include_once("lib/config.php");
include_once("lib/class/class.dbcon.php");

//echo '<pre>'; print_r($item_last_updated); exit;
$body   =   "blank.tpl";
?>