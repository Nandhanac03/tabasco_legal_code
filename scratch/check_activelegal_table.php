<?php
include_once("lib/config.php");
include_once("lib/class/class.dbcon.php");
$db = new dbcon();
$res = $db->SELECT_MultiFetch("DESCRIBE legal_activelegal");
echo json_encode($res);
?>
