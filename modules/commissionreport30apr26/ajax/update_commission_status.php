<?php
// ajax/save_commission_voucher.php
error_reporting(E_ALL);
session_start();
include_once("../../../lib/config.php");
include_once("../../../lib/class/class.dbcon.php");

$db = new Dbcon();

$voucher_no = $_POST['voucher_no'] ?? null;
$payment_date = $_POST['payment_date'] ?? null;
$payment_method = $_POST['payment_method'] ?? null;
$amount_paid = floatval($_POST['amount_paid'] ?? 0);
$signature_confirmed = $_POST['signature_confirmed'] ?? 0;
$remarks = $_POST['remarks'] ?? '';
$commission_ids = $_POST['commission_ids'] ?? '';

if (!$voucher_no || !$payment_date || !$payment_method || !$amount_paid || !$signature_confirmed || !$commission_ids) {
    echo json_encode(['success'=>false,'message'=>'All required fields must be filled']);
    exit;
}

$ids = array_map('intval', explode(',', $commission_ids));
$placeholders = implode(',', array_fill(0,count($ids),'?'));

// 1️⃣ Update Voucher with payment info
$db->Query(
    "UPDATE legal_commission_voucher
     SET status='Paid', payment_method=?, amount_paid=?, remarks=?, updated_at=NOW()
     WHERE voucher_no=?",
    [$payment_method, $amount_paid, $remarks, $voucher_no]
);

// 2️⃣ Update commission rows
$params = array_merge([$voucher_no], $ids);
$db->Query(
    "UPDATE legal_collection_commission
     SET payment_status='Paid'
     WHERE voucher_id=(SELECT id FROM legal_commission_voucher WHERE voucher_no=?) AND id IN ($placeholders)",
    $params
);

echo json_encode(['success'=>true,'message'=>'Voucher marked as Paid successfully']);
exit;
?>
