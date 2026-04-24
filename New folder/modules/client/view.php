<?php

include_once("lib/class/class.common.php");
$objCommon = new Common();

include_once("lib/class/class.legal_common_selection.php");
$objCommonSelection = new CommonSelection();

include_once("lib/class/class.legal_client.php");
$objClients = new Clients();

include_once("lib/class/class.legal_document.php");
$ObjprocessDocument = new processDocument();

include_once("lib/class/class.legal_contact.php");
$ObjContact = new Contact();

include_once("lib/class/class.legal_cheque.php");
$ObjCheque = new Cheque();



include_once("lib/class/class.legal_plantiff.php");
$Objplantiff = new Plantiff();



include_once("lib/class/class.legal_defender.php");
$Objdefender = new Defender();



$edit_id        =   trim($_GET['param1']);
$action         =   trim($_GET['action']);


if(!$edit_id){
    header("location: " . ROOT_DIR . "permission_denied.php");
    exit;
}



$data = array();
if($edit_id > 0)
$data   =   $objClients->Get_Client_Information($edit_id)[0];

if(!isset($data['code']) && !isset($data['marketing'])){
    header("location: " . ROOT_DIR . "client/list.html");
    exit;

}


$array_document =   array();
if($data['id'] > 0){
    $array_document =   $ObjprocessDocument->get_document('',$data['id'],'C');
}

$array_contact  =   array();
$array_contact  = $ObjContact->get_contact('',$data['id'],'C');



$array_plantiff  =   array();
$array_plantiff  = $Objplantiff->get_plantiff('',$data['id'],'C');

$array_defender  =   array();
$array_defender  = $Objdefender->get_defender('',$data['id'],'C');

$array_cheque  =   array();
$array_cheque  = $ObjCheque->get_cheque('',$data['id'],'C');

$actve_sub_menu = 'dashboard';
$body   =   "view.tpl";
