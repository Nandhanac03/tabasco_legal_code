<?php
ob_start();
session_start();
error_reporting(0);
include_once("../../../lib/config.php");
include_once("../../../lib/class/class.dbcon.php");
include_once("../../../lib/class/class.legal_client.php");

$objClients = new Clients();
$limit = PAGINATION_PERPAGE;

//Collectiong Post Values

$marketing  =   trim($_POST['marketing']);
$client     =   trim($_POST['client']);
$fromDate   =   trim($_POST['fromDate']);
$toDate     =   trim($_POST['toDate']);
$keyword    =   trim($_POST['keyword']);




// ✅ Sanitize & Validate Page Number
$page_no = isset($_POST['page_no']) ? max(1, intval($_POST['page_no'])) : 1;
$offset = ($page_no - 1) * $limit;

// ✅ Optimize SQL Calls (Single Execution)
$totalData = $objClients->Get_Client_TOTAL_COUNT('', '', 'A',$client,$keyword,$marketing,$fromDate,$toDate)[0]['TOTAL_RECORDS'];
$clients = $objClients->Get_Client_Information($client, '', $keyword, 'A', '', $offset, $limit,$marketing,$fromDate,$toDate);

// ✅ Precompute Pagination Variables
$totalPage = max(1, ceil($totalData / $limit));
$start_page = max(1, $page_no - 5);
$end_page = min($totalPage, $start_page + 9);
$prev_val = max(1, $page_no - 1);
$next_val = min($totalPage, $page_no + 1);

// ✅ Faster Pagination Rendering
$pagination = [
    '<ul class="pagination justify-content-center" style="margin:20px 0">',
    '<li class="page-item"><a class="page-link" id="1" href="#">First</a></li>',
    '<li class="page-item"><a class="page-link" id="'.$prev_val.'" href="#">Prev</a></li>'
];

for ($ipg = $start_page; $ipg <= $end_page; $ipg++) {
    $pagination[] = '<li class="page-item '.($ipg == $page_no ? 'active' : '').'">
                        <a class="page-link" id="'.$ipg.'" href="#">'.$ipg.'</a>
                    </li>';
}

$pagination[] = '<li class="page-item"><a class="page-link" id="'.$next_val.'" href="#">Next</a></li>';
$pagination[] = '<li class="page-item"><a class="page-link" id="'.$totalPage.'" href="#">Last</a></li>';
$pagination[] = '</ul>';

$pagination_output = implode("\n", $pagination);

// ✅ Faster HTML Table Rendering
if ($totalData > 0) {
    echo '<table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Code</th>
                    <th></th>
                    <th>Client</th>
                    <th>Email ID</th>
                    <th>Contact Name & No.</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>';

    $rowCnt = $offset + 1;
    $rows = [];
//$rowCnt++
    foreach ($clients as $client) {
        $rows[] = '<tr>
                    <td>' . $client['code'] . '</td>
                    <td>' . htmlspecialchars(strip_tags(str_replace('&nbsp;', ' ', $client['marketing_person'] ?? '-'))) . ' <b>' .htmlspecialchars(strip_tags(str_replace('&nbsp;', ' ', $client['usertype_title'] ?? '-'))).'</b></td>
<td>'. htmlspecialchars(strip_tags(str_replace('&nbsp;', ' ', $client['name'] ?? '-'))) . '</td>
<td>' . htmlspecialchars(strip_tags(str_replace('&nbsp;', ' ', $client['email'] ?? '-'))) . '</td>
<td>' . htmlspecialchars(strip_tags(str_replace('&nbsp;', ' ', $client['contact_person'] ?? '-'))) . ' ' .
     htmlspecialchars(strip_tags(str_replace('&nbsp;', ' ', $client['mobile_number'] ?? '-'))) . '</td>

                    <td>Open</td>
                    <td>
<a type="button" href="' . ROOT_DIR . 'client/view/info/' . intval($client['id'] ?? 0) . '.html" class="btn btn-primary" title="View"><i class="fadeIn animated bx bx-arrow-from-left"></i></a>




                    </td>
                  </tr>';
    }

    echo implode("\n", $rows);
    echo '</tbody></table>';
} else {
    echo '<div style="width: 100%; text-align: center; padding: 50px 0; color: #ff0000; font-size: 20px;">
            No records found
          </div>';
}

// ✅ Display Pagination Only If Needed
if ($totalData > PAGINATION_PERPAGE) echo $pagination_output;
?>
