<?php

include_once("lib/class/class.legal_master.php");
$ObjMasterdata   =   new Masterdata();

$edit_id        =   trim($_GET['param1']);
$action         =   trim($_GET['action']);

if(!$edit_id){
    header("location: " . ROOT_DIR . "permission_denied.php");
    exit;
}

$array_document_type    =   array();
$array_document_type    =   $ObjMasterdata->get_DocumentType();

$actve_sub_menu = 'dashboard';
$body   =   "document.tpl";