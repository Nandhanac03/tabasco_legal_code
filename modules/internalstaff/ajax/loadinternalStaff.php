<?php
ob_start();
session_start();
error_reporting(0);
include_once("../../../lib/config.php");
include_once("../../../lib/class/class.dbcon.php");
include_once("../../../lib/class/class.legal_users.php");

$ObjUsersClass = new UsersClass();
$limit = PAGINATION_PERPAGE;

// Collect POST values
$keyword = trim($_POST['keyword']);

// ✅ Sanitize & Validate Page Number
$page_no = isset($_POST['page_no']) ? max(1, intval($_POST['page_no'])) : 1;
$offset = ($page_no - 1) * $limit;

// ✅ Single Execution for count & data
$totalData = $ObjUsersClass->Get_Users_TOTAL_COUNT( 'A', $keyword,22)[0]['TOTAL_RECORDS'];
$usersList = $ObjUsersClass->get_all_Users(null, $keyword,22, $offset, $limit);

// ✅ Pagination Computation
$totalPage = max(1, ceil($totalData / $limit));
$start_page = max(1, $page_no - 5);
$end_page = min($totalPage, $start_page + 9);
$prev_val = max(1, $page_no - 1);
$next_val = min($totalPage, $page_no + 1);

// ✅ Pagination Links
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

// ✅ User Table Rendering
if ($totalData > 0) {
    echo '<table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Email ID</th>
                    <th>Mobile No.</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>';

    $rowCnt = $offset + 1;
    $rows = [];

    foreach ($usersList as $userRows) {
        $rows[] = '<tr>
                    <td>' . $rowCnt++ . '</td>
                    <td>' . htmlspecialchars(strip_tags($userRows['user_name'] ?? '-')) . '</td>
                    <td>' . htmlspecialchars(strip_tags(str_replace('&nbsp;', ' ', $userRows['user_address'] ?? '-'))) . '</td>
                    <td>' . htmlspecialchars(strip_tags(str_replace('&nbsp;', ' ', $userRows['user_emailId'] ?? '-'))) . '</td>
                    <td>' . htmlspecialchars(strip_tags(str_replace('&nbsp;', ' ', $userRows['user_mob'] ?? '-'))) . '</td>
                    <td>
                        <a type="button" href="' . ROOT_DIR . 'internalstaff/information/edit/' . intval($userRows['user_Id'] ?? 0) . '.html" class="btn btn-primary" title="View">
                           <i class="fadeIn animated bx bx-pencil"></i>
                        </a>
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

// ✅ Show Pagination only if necessary
if ($totalData > PAGINATION_PERPAGE) {
    echo $pagination_output;
}
?>
