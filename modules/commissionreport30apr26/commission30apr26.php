<?php
ob_start();
session_start();
# including files here
include_once("lib/config.php");
include_once("lib/class/class.dbcon.php");
include_once("lib/class/class.legal_collection_commission.php");
include_once("lib/class/class.legal_commission_voucher.php");
$objCollectionCommission = new LegalCollectionCommission();
$objCommissionVoucher = new LegalCommissionVoucher();

include_once("lib/class/class.legal_case.php");
$objLegalCase = new LegalCase();

include_once("lib/class/class.legal_client.php");
$objClients = new Clients();

$array_legal_case    =   array();
$array_legal_case = $objLegalCase->get_legal_case();

$array_legal_clients = array();
$array_legal_clients = $objClients->Get_Client_Information(null, null, null, 'A');

include_once("lib/auth.php");
if (LEGAL_AUTH_VIEW==false){
    header("Location: ".ROOT_DIR."permission_denied.php");
    exit();
}


$commissions = $objCollectionCommission->get_collection_commission_aggregates();
$test1 = $objCollectionCommission->get_collection_commission_with_collection(['active_legal_id'=>$active_legal_id]);

// echo '<pre>';
// print_r($commissions);
// exit;
$voucher_list = $objCommissionVoucher->get_all_vouchers();
$vouchers = $objCommissionVoucher->get_all_vouchers();

// echo '<pre>';
// print_r($vouchers);
// exit;

$body = "commission.tpl";