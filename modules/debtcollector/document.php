<?php

include_once("lib/class/class.legal_master.php");

$ObjMasterdata = new Masterdata();

# Securely fetch and sanitize GET parameters
$edit_id = filter_input(INPUT_GET, 'param1', FILTER_SANITIZE_NUMBER_INT);
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);

# Redirect if edit_id is missing or invalid
if (!$edit_id || !is_numeric($edit_id)) {
    header("Location: " . ROOT_DIR . "permission_denied.php");
    exit;
}

# Fetch document types securely
$array_document_type = $ObjMasterdata->get_DocumentType() ?? [];
$actve_sub_menu = 'dashboard';
$body = "document.tpl";
?>
