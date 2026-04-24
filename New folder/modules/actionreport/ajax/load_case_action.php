<?php

ob_start();

session_start();

error_reporting(0);



include_once("../../../lib/config.php");

include_once("../../../lib/class/class.dbcon.php");

include_once("../../../lib/class/class.legal_active_legals.php");



$objActiveLegal = new ActiveLegal();

$limit = PAGINATION_PERPAGE;



// ✅ Sanitize Input

$marketing  = trim($_POST['marketing'] ?? '');

$client     = trim($_POST['client'] ?? '');

$fromDate   = preg_match('/^\d{4}-\d{2}-\d{2}$/', $_POST['fromDate'] ?? '') ? $_POST['fromDate'] : '';

$toDate     = preg_match('/^\d{4}-\d{2}-\d{2}$/', $_POST['toDate'] ?? '') ? $_POST['toDate'] : '';

$keyword    = htmlspecialchars(strip_tags(trim($_POST['keyword'] ?? '')));



// ✅ Validate Page Number

$page_no = isset($_POST['page_no']) ? max(1, intval($_POST['page_no'])) : 1;

$offset = ($page_no - 1) * $limit;



// ✅ Fetch Total Records

$totalData = 0;

$countResult = $objActiveLegal->Get_LEGAL_TOTAL_COUNT('', '', 'A','Active');

if (is_array($countResult) && isset($countResult[0]['TOTAL_RECORDS'])) {

    $totalData = (int)$countResult[0]['TOTAL_RECORDS'];
}



// ✅ Fetch Paginated Legal Data

$filters = [

    'status' => 'A',

    'legal_status' => 'Active',

    'limit' => $limit,

    'offset' => $offset

    // You can also add 'fromDate', 'toDate', 'marketing', etc., if your method supports filtering

];



$legalData = $objActiveLegal->Get_ActiveLegal_Information($filters);



// ✅ Pagination Setup

$totalPage = max(1, ceil($totalData / $limit));

$start_page = max(1, $page_no - 5);

$end_page = min($totalPage, $start_page + 9);

$prev_val = max(1, $page_no - 1);

$next_val = min($totalPage, $page_no + 1);



// ✅ Pagination HTML

$pagination = [

    '<ul class="pagination justify-content-center" style="margin:20px 0">',

    '<li class="page-item"><a class="page-link" id="1" href="#">First</a></li>',

    '<li class="page-item"><a class="page-link" id="' . $prev_val . '" href="#">Prev</a></li>'

];



for ($ipg = $start_page; $ipg <= $end_page; $ipg++) {

    $activeClass = $ipg == $page_no ? 'active' : '';

    $pagination[] = "<li class='page-item $activeClass'><a class='page-link' id='$ipg' href='#'>$ipg</a></li>";
}



$pagination[] = '<li class="page-item"><a class="page-link" id="' . $next_val . '" href="#">Next</a></li>';

$pagination[] = '<li class="page-item"><a class="page-link" id="' . $totalPage . '" href="#">Last</a></li>';

$pagination[] = '</ul>';



$pagination_output = implode("\n", $pagination);



// ✅ Render Table

if ($totalData > 0 && is_array($legalData)) {

    echo '<table class="table align-middle mb-0">

        <thead class="table-light">

            <tr>


                <th>Date</th>

                <th>Marketing</th>

                <th>Client</th>

                <th>Present <br>Legal Firm</th>

                <th>Last <br>Action & Date</th>

                <th></th>

            </tr>

        </thead>

        <tbody>';



    foreach ($legalData as $row) {

        echo '<tr>


            <td>' . htmlspecialchars($row['dateon'] ?? '-') . '</td>

            <td>' . htmlspecialchars($row['User_Client'] ?? '-') . ' <b>' . htmlspecialchars($row['Usertype_Client'] ?? '-') . '</b></td>

            <td>' . htmlspecialchars($row['ClientName'] ?? '-') . '</td>

           <td>' . htmlspecialchars($row['Present_Legal_Firm_Name'] ?? '-') . '</td>

            <td>

                <div class="btn-group">

                    <a type="button" class="btn btn-success" href="' . ROOT_DIR . 'actionreport/caselist/view/' . intval($row['id'] ?? 0) . '.html' . '"><i class="lni lni-eye"></i></a>

                </div>

            </td>

        </tr>';
    }



    echo '</tbody></table>';
} else {

    echo '<div style="width: 100%; text-align: center; padding: 50px 0; color: #ff0000; font-size: 20px;">

        No records found

    </div>';
}



// ✅ Render Pagination Only If Needed

if ($totalData > $limit) {

    echo $pagination_output;
}


