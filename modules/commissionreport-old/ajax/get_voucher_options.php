<?php
session_start();
include_once("../../../lib/config.php");
include_once("../../../lib/class/class.dbcon.php");

$db = new Dbcon();

// Only fetch unpaid vouchers
$vouchers = $db->SELECT_MultiFetch(
    "SELECT voucher_no, total_amount 
     FROM legal_commission_voucher 
     WHERE status != 'Paid' 
     ORDER BY id DESC",
    []
);

echo '<option value="">Select Voucher</option>';

if (!empty($vouchers)) {
    foreach ($vouchers as $val) {
        echo '<option value="' . htmlspecialchars($val['voucher_no']) . '">'
           . htmlspecialchars($val['voucher_no'])
           . '</option>';
    }
} else {
    echo '<option value="" disabled>No unpaid vouchers found</option>';
}
?>
