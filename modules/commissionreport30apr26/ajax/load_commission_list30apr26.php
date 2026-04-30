<?php
error_reporting(0);
ini_set('display_errors', 0);
session_start();

include_once("../../../lib/config.php");
include_once("../../../lib/class/class.dbcon.php");
include_once("../../../lib/class/class.legal_collection_commission.php");

$objCollectionCommission = new LegalCollectionCommission();

// ✅ Sanitize Input
$case_id    = trim($_POST['case_id'] ?? '');
$client_id  = trim($_POST['client_id'] ?? '');

$filters = [
    'status'  => 'A',
    'case_id' => $case_id,
    'client'  => $client_id
];

$commissions = $objCollectionCommission->get_collection_commission_aggregates($filters);

if ($commissions) {
    echo '<table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Sl no.</th>
                    <th>Client Name</th>
                    <th>Claim Amount</th>
                    <th>Received Collection</th>
                    <th>Payment Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>';
    foreach ($commissions as $key => $commission) {
        echo '<tr>
                <td>' . (++$key) . '</td>
                <td>' . htmlspecialchars($commission['client_name']) . '</td>
                <td>' . number_format($commission['total_outstanding'], 2) . '</td>
                <td>' . number_format($commission['total_collection_amount'], 2) . '</td>
                <td>Pending</td>
                <td>
                    <a href="#"
                        class="btn btn-sm open-modal"
                        data-id="' . $commission['active_legal_id'] . '"
                        data-bs-toggle="modal"
                        data-bs-target="#exampleExtraLargeModal">
                        <i class="fadeIn animated bx bx-info-circle"></i>
                    </a>
                </td>
            </tr>';
    }
    echo '</tbody></table>';
} else {
    echo '<div style="width: 100%; text-align: center; padding: 50px 0; color: #ff0000; font-size: 20px;">
            No records found
          </div>';
}
?>
