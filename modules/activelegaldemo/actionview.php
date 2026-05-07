<?php

ob_start();

session_start();

# including files here

include_once("lib/config.php");
include_once("lib/class/class.dbcon.php");
include_once("lib/class/class.legal_active_legals.php");
$objActiveLegal = new ActiveLegal();

$action = $_GET['action'];
$id = $_GET['param1'];
$shifted_records = $objActiveLegal->get_shifting_withLegal($id, '', '', true);
$filter = ['id' => $shifted_records[0]['active_legal_id']];
$active_legal = $objActiveLegal->Get_ActiveLegal_Information($filter);
// echo '<pre>';print_r($active_legal);exit;

$actve_sub_menu = 'dashboard';

$body   =   "actionview.tpl";