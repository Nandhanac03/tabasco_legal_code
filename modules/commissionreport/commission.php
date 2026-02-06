<?php
ob_start();
session_start();
# including files here
include_once("lib/config.php");
include_once("lib/class/class.dbcon.php");
include_once("lib/class/class.legal_collection_commission.php");
$objCollectionCommission = new LegalCollectionCommission();


$commissions = $objCollectionCommission->get_collection_commission_aggregates();
$test1 = $objCollectionCommission->get_collection_commission_with_collection(['active_legal_id'=>$active_legal_id]);

// echo '<pre>';
// print_r($commissions);
// exit;


$body = "commission.tpl";