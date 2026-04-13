<?php





include_once("lib/class/class.legal_master.php");


$ObjMasterdata   =   new Masterdata();


include_once("lib/auth.php");
if (LEGAL_AUTH_VIEW==false){
    header("Location: ".ROOT_DIR."permission_denied.php");
    exit();
}





$main_menu =   'reports';


$body           =   "list.tpl";

