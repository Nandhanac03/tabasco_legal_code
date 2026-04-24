<?php
error_reporting(0);
ini_set('display_errors', 1);
session_start();

include_once("../../../lib/config.php");
include_once("../../../lib/class/class.dbcon.php");
include_once("../../../lib/class/class.legal_collection_commission.php");

$objCollectionCommission = new LegalCollectionCommission();

$active_legal_id = $_POST['active_legal_id'] ?? null;

if ($active_legal_id) {

    $data = $objCollectionCommission->get_collection_commission_with_collection([
        'active_legal_id' => $active_legal_id
    ]);

    if (!empty($data)) {

        $total_received_collection = 0;
        $total_commission_payable = 0;

        $client_name = htmlspecialchars($data[0]['client_name'] ?? '');
        $total_outstanding = floatval($data[0]['total_outstanding'] ?? 0);

        echo '<div style="margin-bottom:10px;font-weight:700;color:#a94442;">';
        echo 'Client: '.$client_name.' | Claim Amount: '.number_format($total_outstanding,2);
        echo '</div>';

        echo '<table class="table table-bordered">';
        echo '<thead>
                <tr>
                    <th><input type="checkbox" id="checkAll"></th>
                    <th>Party</th>
                    <th>Received Collection</th>
                    <th>Commission (%)</th>
                    <th>Commission Payable</th>
                    <th>Status</th>
                </tr>
              </thead>';
        echo '<tbody>';

        foreach ($data as $row) {

            $status = $row['payment_status'] ?? 'Pending';

            $total_received_collection += floatval($row['amount']);
            $total_commission_payable += floatval($row['received_amount']);

            $disabled = ($status == 'Paid') ? 'disabled' : '';
            $rowStyle = ($status == 'Paid') ? 'style="background:#f5f5f5;"' : '';

            $badgeClass = ($status == 'Printed')
                ? 'bg-success'
                : (($status == 'Paid') ? 'bg-primary' : 'bg-warning text-dark');

            echo "<tr $rowStyle>";

            echo '<td>
                <input type="checkbox"
                    class="row-check"
                    '.$disabled.'
                    data-status="'.$status.'"
                    data-id="'.intval($row['id']).'"
                    data-party="'.htmlspecialchars($row['Present_Legal_Firm_Name']).'"
                    data-received="'.floatval($row['amount']).'"
                    data-commission="'.htmlspecialchars($row['commission_percentage']).'"
                    data-payable="'.floatval($row['received_amount']).'">
            </td>';

            echo '<td>'.htmlspecialchars($row['Present_Legal_Firm_Name']).'</td>';
            echo '<td>'.number_format($row['amount'],2).'</td>';
            echo '<td>'.htmlspecialchars($row['commission_percentage']).'</td>';
            echo '<td>'.number_format($row['received_amount'],2).'</td>';
            echo '<td><span class="badge status-badge '.$badgeClass.'">'.$status.'</span></td>';

            echo '</tr>';
        }

        echo '<tr style="font-weight:bold;background:#f8f9fa;">';
        echo '<td></td>';
        echo '<td class="text-end">Total</td>';
        echo '<td>'.number_format($total_received_collection,2).'</td>';
        echo '<td></td>';
        echo '<td>'.number_format($total_commission_payable,2).'</td>';
        echo '<td></td>';
        echo '</tr>';

        echo '</tbody></table>';

        echo '<button id="generatePdfBtn"
                class="btn btn-danger btn-sm mt-2"
                style="display:none;">Generate PDF</button>';

    } else {
        echo '<p>No data found.</p>';
    }

} else {
    echo '<p>Invalid request.</p>';
}
?>
