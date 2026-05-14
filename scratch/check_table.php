<?php
include_once("lib/class/class.dbcon.php");
$db = new dbcon();
$res = $db->Query("DESCRIBE legal_client");
echo json_encode($db->SELECT_MultiFetch("DESCRIBE legal_client"));
?>
