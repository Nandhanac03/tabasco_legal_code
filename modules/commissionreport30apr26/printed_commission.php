<?php
ob_start();
session_start();

include_once("lib/config.php");
include_once("lib/class/class.dbcon.php");
include_once("lib/class/class.legal_collection_commission.php");
include_once("lib/class/class.legal_commission_voucher.php");
$objCollectionCommission = new LegalCollectionCommission();
$objCommissionVoucher = new LegalCommissionVoucher();   



$voucher_list = $objCommissionVoucher->get_all_vouchers();


$vouchers = $objCommissionVoucher->get_all_commission_vouchers();
// echo"<pre>";
// print_r($voucher_list);
// exit;



$body = "printed_commission.tpl";