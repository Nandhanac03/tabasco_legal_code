<?php
ob_start();
session_start();
error_reporting(0);

include_once("../../../lib/config.php");
include_once("../../../lib/class/class.dbcon.php");
include_once("../../../lib/class/class.legal_active_legals.php");

$objActiveLegal = new ActiveLegal();
$limit = PAGINATION_PERPAGE;

// CHANGE 1: Read filter names that match what the view sends
$case_id   = trim($_POST['case_id']   ?? '');
$client_id = trim($_POST['client_id'] ?? '');

// Validate page number
$page_no = isset($_POST['page_no']) ? max(1, intval($_POST['page_no'])) : 1;
$offset  = ($page_no - 1) * $limit;

// CHANGE 2: Build filters array to pass into the class methods
$filters = [
    'status'       => 'A',
    'legal_status' => '',
    'limit'        => $limit,
    'offset'       => $offset
];

// CHANGE 3: Add case_id and client_id to filters only when provided
if (!empty($case_id)) {
    $filters['case_id'] = intval($case_id);
}
if (!empty($client_id)) {
    $filters['client_id'] = intval($client_id);
}

// CHANGE 4: Pass filters into count AND data fetch so both are filtered
$totalData   = 0;
$countResult = $objActiveLegal->Get_LEGAL_TOTAL_COUNT('', '', 'A', 'Active', $filters);
if (is_array($countResult) && isset($countResult[0]['TOTAL_RECORDS'])) {
    $totalData = (int)$countResult[0]['TOTAL_RECORDS'];
}

$legalData = $objActiveLegal->Get_ActiveLegal_Information($filters);

// Pagination setup
$totalPage  = max(1, ceil($totalData / $limit));
$start_page = max(1, $page_no - 5);
$end_page   = min($totalPage, $start_page + 9);
$prev_val   = max(1, $page_no - 1);
$next_val   = min($totalPage, $page_no + 1);

// Pagination HTML
$pagination = [
    '<ul class="pagination justify-content-center" style="margin:20px 0">',
    '<li class="page-item"><a class="page-link" id="1" href="#">First</a></li>',
    '<li class="page-item"><a class="page-link" id="' . $prev_val . '" href="#">Prev</a></li>'
];
for ($ipg = $start_page; $ipg <= $end_page; $ipg++) {
    $activeClass  = $ipg == $page_no ? 'active' : '';
    $pagination[] = "<li class='page-item $activeClass'><a class='page-link' id='$ipg' href='#'>$ipg</a></li>";
}
$pagination[] = '<li class="page-item"><a class="page-link" id="' . $next_val . '" href="#">Next</a></li>';
$pagination[] = '<li class="page-item"><a class="page-link" id="' . $totalPage . '" href="#">Last</a></li>';
$pagination[] = '</ul>';
$pagination_output = implode("\n", $pagination);

// Render table
if ($totalData > 0 && is_array($legalData)) {

    echo '<table class="table align-middle mb-0">
        <thead class="table-light">
            <tr>
                <th>Date</th>
                <th>Marketing</th>
                <th>Client</th>
                <th>Legal Status</th>
                <th>Present <br>Legal Firm</th>
                <th>Option</th>
            </tr>
        </thead>
        <tbody>';

    foreach ($legalData as $row) {
        if ($row['legal_status'] == 'Bad_debts') {
            $row['legal_status'] = 'Bad debts';
        }

        echo '<tr>
            <td>' . htmlspecialchars($row['dateon'] ?? '-') . '</td>
            <td>' . htmlspecialchars($row['User_Client'] ?? '-') . ' <b>' . htmlspecialchars($row['Usertype_Client'] ?? '-') . '</b></td>
            <td>' . htmlspecialchars($row['ClientName'] ?? '-') . '</td>
            <td>' . htmlspecialchars($row['legal_status'] ?? '-') . '</td>
            <td>' . htmlspecialchars($row['Present_Legal_Firm_Name'] ?? '-') . '</td>
            <td>
                <div class="btn-group">
                    <a class="btn btn-success" href="' . ROOT_DIR . 'reports/clientbase_action_report_client/view/' . intval($row['id'] ?? 0) . '.html">
                        <i class="lni lni-eye"></i>
                    </a>
                </div>
            </td>
        </tr>';
    }

    echo '</tbody></table>';

} else {
    echo '<div style="width:100%; text-align:center; padding:50px 0; color:#ff0000; font-size:20px;">
        No records found
    </div>';
}

if ($totalData > $limit) {
    echo $pagination_output;
}