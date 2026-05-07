<?php
ob_start();
session_start();
error_reporting(0);

include_once("../lib/config.php");
include_once("../lib/class/class.dbcon.php");
include_once("../lib/class/class.legal_client.php");

$objClients = new Clients();

/* =========================
   GET FILTER VALUES
========================= */

$marketing  = trim($_GET['marketing'] ?? '');
$client     = trim($_GET['client'] ?? '');
$fromDate   = trim($_GET['fromDate'] ?? '');
$toDate     = trim($_GET['toDate'] ?? '');
$keyword    = trim($_GET['keyword'] ?? '');

/* =========================
   FETCH DATA
========================= */

$clients = $objClients->Get_Client_Information(
    $client,
    '',
    $keyword,
    'A',
    '',
    0,
    999999,
    $marketing,
    $fromDate,
    $toDate
);

/* =========================
   EXCEL HEADER
========================= */

$fileName = "client_list_" . date("Ymd_His") . ".xls";

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$fileName\"");

/* =========================
   TABLE START
========================= */

echo '<table border="1">';

echo '
<tr style="font-weight:bold; background:#cccccc;">
    <th>Code</th>
    <th>Marketing</th>
    <th>User Type</th>
    <th>Client</th>
    <th>Email ID</th>
    <th>Contact Person</th>
    <th>Mobile Number</th>
    <th>Status</th>
</tr>
';

/* =========================
   TABLE ROWS
========================= */

if (!empty($clients)) {

    foreach ($clients as $clientData) {

        echo '<tr>

            <td>' . htmlspecialchars($clientData['code']) . '</td>

            <td>' . htmlspecialchars(
                strip_tags(
                    str_replace('&nbsp;', ' ', $clientData['marketing_person'] ?? '-')
                )
            ) . '</td>

            <td>' . htmlspecialchars(
                strip_tags(
                    str_replace('&nbsp;', ' ', $clientData['usertype_title'] ?? '-')
                )
            ) . '</td>

            <td>' . htmlspecialchars(
                strip_tags(
                    str_replace('&nbsp;', ' ', $clientData['name'] ?? '-')
                )
            ) . '</td>

            <td>' . htmlspecialchars(
                strip_tags(
                    str_replace('&nbsp;', ' ', $clientData['email'] ?? '-')
                )
            ) . '</td>

            <td>' . htmlspecialchars(
                strip_tags(
                    str_replace('&nbsp;', ' ', $clientData['contact_person'] ?? '-')
                )
            ) . '</td>

            <td>' . htmlspecialchars(
                strip_tags(
                    str_replace('&nbsp;', ' ', $clientData['mobile_number'] ?? '-')
                )
            ) . '</td>

            <td>Open</td>

        </tr>';
    }

} else {

    echo '
    <tr>
        <td colspan="8" align="center">No records found</td>
    </tr>';
}

echo '</table>';
exit;
?>