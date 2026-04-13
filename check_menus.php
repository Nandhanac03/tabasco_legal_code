<?php
include_once("lib/config.php");
include_once("lib/class/class.dbcon.php");

$db = new dbcon();

echo "Legal Menus:\n";
$menus = $db->SELECT_MultiFetch("SELECT * FROM legal_menu");


// print_r($menus);
// exit;
foreach($menus as $menu) {
    echo $menu['id'] . " - " . $menu['menu_name'] . "\n";
}
