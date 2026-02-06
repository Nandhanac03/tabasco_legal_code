<?php
ob_start();
session_start();
error_reporting(0);

include_once("../../../lib/config.php");
include_once("../../../lib/class/class.dbcon.php");

include_once("../../../lib/class/class.legal_debt_collector.php");
$ObjDebtCollector = new DebtCollector();

$limit = PAGINATION_PERPAGE; // Define items per page
$keyword = isset($_POST['keyword']) ? trim($_POST['keyword']) : '';

// ✅ Sanitize and Validate Page Number
$page_no = isset($_POST['page_no']) ? max(1, intval($_POST['page_no'])) : 1;
$offset = ($page_no - 1) * $limit;

// ✅ Fetch Total Records & Paginated Data (Single Query Execution)
$totalData = (int) ($ObjDebtCollector->Get_Debt_Collector_TOTAL_COUNT('', '', 'A', $keyword)[0]['TOTAL_RECORDS'] ?? 0);

$filters    =   array();
$filters['limit']   =   $limit;
$filters['offset']  =   $offset;
$filters['search']  =   $keyword;
$filters['status']  =   'A';
$debtCollector      =   $ObjDebtCollector->getDebtCollectorInfo($filters);

// ✅ Compute Pagination Variables
$totalPage  = max(1, ceil($totalData / $limit));
$start_page = max(1, $page_no - 5);
$end_page   = min($totalPage, $start_page + 9);
$prev_val   = max(1, $page_no - 1);
$next_val   = min($totalPage, $page_no + 1);


// ✅ Generate Pagination Links Only If Needed
if ($totalData > $limit) {
    $pagination = [
        '<ul class="pagination justify-content-center" style="margin:20px 0">',
        '<li class="page-item"><a class="page-link" id="1" href="#">First</a></li>',
        '<li class="page-item"><a class="page-link" id="' . $prev_val . '" href="#">Prev</a></li>'
    ];

    for ($ipg = $start_page; $ipg <= $end_page; $ipg++) {
        $pagination[] = '<li class="page-item ' . ($ipg == $page_no ? 'active' : '') . '">
                            <a class="page-link" id="' . $ipg . '" href="#">' . $ipg . '</a>
                         </li>';
    }

    $pagination[] = '<li class="page-item"><a class="page-link" id="' . $next_val . '" href="#">Next</a></li>';
    $pagination[] = '<li class="page-item"><a class="page-link" id="' . $totalPage . '" href="#">Last</a></li>';
    $pagination[] = '</ul>';

    $pagination_output = implode("\n", $pagination);
} else {
    $pagination_output = '';
}

// ✅ Render Data Table
if ($totalData > 0) {
    echo '<table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Contact Number</th>
                    <th>Email ID</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>';

    foreach ($debtCollector as $debtCollectorRows) {

        $edit_url = ROOT_DIR . "debtcollector/information/edit/" . intval($debtCollectorRows['id'] ?? 0) . ".html";
        echo '<tr>
                <td>' . htmlspecialchars(strip_tags($debtCollectorRows['code'] ?? '-')) . '</td>
                <td>' . htmlspecialchars(strip_tags(str_replace('&nbsp;', ' ', $debtCollectorRows['name'] ?? '-'))) . '</td>
                <td>' . htmlspecialchars(strip_tags(str_replace('&nbsp;', ' ', $debtCollectorRows['contact_no'] ?? '-'))) . '</td>
                <td>' . htmlspecialchars(strip_tags(str_replace('&nbsp;', ' ', $debtCollectorRows['email'] ?? '-'))) . '</td>
                                <td>
    <div class="btn-group">

       <a type="button" href="' . ROOT_DIR . 'debtcollector/view/info/' . intval($debtCollectorRows['id'] ?? 0) . '.html" class="btn btn-primary" title="View"><i class="fadeIn animated bx bx-arrow-from-left"></i></a>


    </div>
</td>

              </tr>';
    }

    echo '</tbody></table>';
} else {
    echo '<div class="text-center" style="padding: 50px 0; color: #ff0000; font-size: 20px;">
            No records found
          </div>';
}

// ✅ Display Pagination
echo $pagination_output;
?>
