<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

session_start();

include_once("../../../lib/config.php");
include_once("../../../lib/class/class.dbcon.php");
include_once("../../../lib/class/class.legal_commission_voucher.php");


$objCommissionVoucher = new LegalCommissionVoucher();

$voucher_list = $objCommissionVoucher->get_all_vouchers();

// echo "<pre>";
// print_r($voucher_list);
// exit;


if (!empty($voucher_list)) {

    echo '<div class="table-responsive">';
    echo '<table class="table table-bordered">';
    echo '<thead class="table-light">
            <tr>
                <th>Sl No</th>
                <th>Voucher No</th>
                <th>Voucher Date</th>
                <th>Total Amount</th>
                <th>Status</th>
            </tr>
          </thead>';
    echo '<tbody>';

    $i = 1;

    foreach ($voucher_list as $val) {

        echo '<tr>';
        echo '<td>'.$i++.'</td>';
        echo '<td>'.$val['voucher_no'].'</td>';
        echo '<td>'.$val['voucher_date'].'</td>';
        echo '<td>'.$val['total_amount'].'</td>';
        echo '<td><span class="badge bg-success">'.$val['status'].'</span></td>';
        echo '</tr>';
    }

    echo '</tbody></table></div>';

} else {

    echo '<p class="text-danger text-center">No records found</p>';
}
