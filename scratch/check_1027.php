<?php
include_once("lib/config.php");
include_once("lib/class/class.dbcon.php");
include_once("lib/class/class.legal_active_legals.php");
$obj = new ActiveLegal();
$data = $obj->Get_ActiveLegal_Information(['id' => 1027]);
print_r($data);
