<?php
// Show errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include Composer autoload
require_once '../../../vendor/autoload.php';

// Decode the JSON rows sent via AJAX
$rows = json_decode($_POST['rows'] ?? '[]', true);

if (empty($rows)) {
    exit('No rows selected');
}

// Initialize totals
$total_received = 0;
$total_payable = 0;

// Start HTML for PDF
$html = '
<h2 style="text-align:center;">Commission Report</h2>

<table border="1" cellpadding="8" cellspacing="0" width="100%" style="border-collapse:collapse;">
<thead style="background:#f0f0f0; font-weight:bold;">
<tr>
<th>Party</th>
<th>Received Collection</th>
<th>Commission (%)</th>
<th>Commission Payable</th>
</tr>
</thead>
<tbody>
';

// Loop through rows to populate table
foreach ($rows as $r) {

    $received = floatval($r['received']);
    $payable = floatval($r['payable']);

    $total_received += $received;
    $total_payable += $payable;

    $html .= '
    <tr>
        <td>'.htmlspecialchars($r['party']).'</td>
        <td>'.number_format($received, 2).'</td>
        <td>'.htmlspecialchars($r['commission']).'</td>
        <td>'.number_format($payable, 2).'</td>
    </tr>
    ';
}

// Add total row
$html .= '
<tr style="font-weight:bold; background:#e0e0e0;">
    <td>Total</td>
    <td>'.number_format($total_received, 2).'</td>
    <td></td>
    <td>'.number_format($total_payable, 2).'</td>
</tr>
</tbody>
</table>

<br><br>

Processed By: ______________________ <br><br>
Completed For Signing: ______________________
';


$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'format' => 'A4',
    'margin_left' => 15,
    'margin_right' => 15,
    'margin_top' => 15,
    'margin_bottom' => 15
]);


$mpdf->WriteHTML($html);

$mpdf->Output('Commission_Report.pdf', 'D');
exit;
