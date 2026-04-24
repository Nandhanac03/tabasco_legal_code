<?php
include_once("lib/class/class.common.php");
$objCommon = new Common();

include_once("lib/class/class.legal_common_selection.php");
$objCommonSelection = new CommonSelection();

include_once("lib/class/class.legal_firm.php");
$ObjLegalFirm = new LegalFirm();

include_once("lib/class/class.legal_bank.php");
$ObjbankDetails = new bankDetails();


include_once("lib/class/class.legal_document.php");
$ObjprocessDocument = new processDocument();

include_once("lib/class/class.legal_contact.php");
$ObjContact = new Contact();

include_once("lib/class/class.legal_cheque.php");
$ObjCheque = new Cheque();

include_once("lib/class/class.legal_active_legals.php");
$objActiveLegal = new ActiveLegal();

$id             =   trim($_GET['param1']);
$action         =   trim($_GET['action']);

$data   =   $ObjLegalFirm->getLegalFirmInformation($id)[0];
if(!isset($data['code'])){
    header("location: " . ROOT_DIR . "legalfirm/list.html");
    exit;
}

$commissions = $objActiveLegal->get_commission('', '', 'LF', $id);


$bank_detals  =   array();
$bank_detals  =   $ObjbankDetails->get_bank_account_details('',$id,'LF')[0];

$array_document =   array();
if($data['id'] > 0){
    $array_document =   $ObjprocessDocument->get_document('',$data['id'],'LF');
}

$array_contact  =   array();
$array_contact  = $ObjContact->get_contact('',$data['id'],'LF');

$array_cheque  =   array();
$array_cheque  = $ObjCheque->get_cheque('',$data['id'],'LF');
$actve_sub_menu = 'dashboard';
$body   =   "view.tpl";