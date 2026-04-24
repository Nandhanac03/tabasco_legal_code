<?php

ob_start();

session_start();

error_reporting(0);



include_once("../../../lib/config.php");

include_once("../../../lib/class/class.dbcon.php");

include_once("../../../lib/class/class.legal_active_legals.php");

include_once("../../../lib/class/class.legal_cheque.php");
include_once("../../../lib/class/class.legal_case_root_actions.php");

$objcaseRootAction = new CaseRootAction();

$objCheque =   new Cheque();
$objActiveLegal = new ActiveLegal();

include_once("../../../lib/class/class.legal_expense.php");
$objExpense = new Expense();
include_once("../../../lib/class/class.legal_collection.php");
$objCollection = new Collection();
$limit = PAGINATION_PERPAGE;
include_once("../../../lib/auth_ajax.php");





// ✅ Sanitize Input 

$marketing  = trim($_POST['marketing'] ?? '');

$client     = trim($_POST['client'] ?? '');
$search     = trim($_POST['search_code'] ?? '');
$user_id     = trim($_POST['select_marketing'] ?? '');
$client     = trim($_POST['select_client'] ?? '');



$fromDate   = preg_match('/^\d{4}-\d{2}-\d{2}$/', $_POST['fromDate'] ?? '') ? $_POST['fromDate'] : '';

$toDate     = preg_match('/^\d{4}-\d{2}-\d{2}$/', $_POST['toDate'] ?? '') ? $_POST['toDate'] : '';

$keyword    = htmlspecialchars(strip_tags(trim($_POST['keyword'] ?? '')));



// ✅ Validate Page Number

$page_no = isset($_POST['page_no']) ? max(1, intval($_POST['page_no'])) : 1;

$offset = ($page_no - 1) * $limit;


$search_filter = [];
$search_filter['case_id'] = trim($_POST['select_marketing'] ?? '');
$search_filter['client'] = trim($_POST['select_client'] ?? '');
$search_filter['search'] = $search;


// ✅ Fetch Total Records

$totalData = 0;

$countResult = $objActiveLegal->Get_LEGAL_TOTAL_COUNT('', '', 'A', 'Active', $search_filter);

if (is_array($countResult) && isset($countResult[0]['TOTAL_RECORDS'])) {

    $totalData = (int)$countResult[0]['TOTAL_RECORDS'];
}



// ✅ Fetch Paginated Legal Data 

$filters = [

    'status' => 'A',
    'legal_status' => 'Active',
    'limit' => $limit,
    'offset' => $offset,
    'dateon' => $fromDate,
    'search' => $search,
    'user_id' => $user_id,
    'client' => $client,

    // You can also add 'fromDate', 'toDate', 'marketing', etc., if your method supports filtering

];




$legalData = $objActiveLegal->Get_ActiveLegal_Information($filters);

if ($legalData) {
    foreach ($legalData as $key => $value) {

        $with_client = $objCheque->get_cheque_total($value['client'], 'C');
        $wit_case    = $objCheque->get_cheque_total($value['client'], 'CA');
        $case_filter = array();
        $case_filter['created_from'] = 'CA';
        $case_filter['active_legal_id'] = $value['id'];
        $case_roots = $objcaseRootAction->get_case_root('',  $case_filter);
        $last_case_root = $case_roots[0];
        $legalData[$key]['last_case_action']         = isset($last_case_root['description']) ? $last_case_root['description'] : '';
        $legalData[$key]['last_case_date']         = isset($last_case_root['date']) ? $last_case_root['date'] : '';
        $total_Expense = 0;
        $total_Expense = $objExpense->total_expense($value['id']);
        $legalData[$key]['total_Expense'] = $total_Expense;
        $total_collection = $objCollection->total_collection($value['id']);
        $legalData[$key]['total_collection'] = $total_collection;


        // Safely extract values from both queries
        $with_client_total1 = isset($with_client[0]['Total1']) ? (float)$with_client[0]['Total1'] : 0;
        $with_client_total2 = isset($with_client[0]['Total2']) ? (float)$with_client[0]['Total2'] : 0;

        $wit_case_total1 = isset($wit_case[0]['Total1']) ? (float)$wit_case[0]['Total1'] : 0;
        $wit_case_total2 = isset($wit_case[0]['Total2']) ? (float)$wit_case[0]['Total2'] : 0;

        // Combine totals
        $outstanding_cheque         = $with_client_total1 + $wit_case_total1;
        $outstanding_without_cheque = $with_client_total2 + $wit_case_total2;
        $total_outstanding          = $outstanding_cheque + $outstanding_without_cheque;

        // Add new fields to result object


        $legalData[$key]['final_outstanding_cheque']         = $outstanding_cheque;
        $legalData[$key]['final_outstanding_without_cheque'] = $outstanding_without_cheque;
        $legalData[$key]['final_total_outstanding']          = $total_outstanding;
    }
}

// echo '<pre>';
// print_r($legalData);
// exit;

// ✅ Pagination Setup

$totalPage = max(1, ceil($totalData / $limit));

$start_page = max(1, $page_no - 5);

$end_page = min($totalPage, $start_page + 9);

$prev_val = max(1, $page_no - 1);

$next_val = min($totalPage, $page_no + 1);




// ✅ Pagination Setup

$totalPage = max(1, ceil($totalData / $limit));

$start_page = max(1, $page_no - 5);

$end_page = min($totalPage, $start_page + 9);

$prev_val = max(1, $page_no - 1);

$next_val = min($totalPage, $page_no + 1);




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

              

             

                <th style="border: 1px solid #00000014;">Marketing</th>

                <th style="border: 1px solid #00000014;">Client/<br>
                Date</th>

                <th style="border: 1px solid #00000014;">Present <br>Legal Firm</th>

                <th style="border: 1px solid #00000014;">Case <br>Status</th>

                <th style="border: 1px solid #00000014;">Legal <br>Status</th>

                <th style="border: 1px solid #00000014;">Claim <br>Amount</th>

                <th style="border: 1px solid #00000014;">Collection <br>Received</th>

                <th style="border: 1px solid #00000014;">Balance <br>to Claim</th>

                <th style="border: 1px solid #00000014;"> Expense</th>

                <th style="border: 1px solid #00000014;">Last <br>Action & Date</th>

                <th style="border: 1px solid #00000014;">Option</th>

            </tr>

        </thead>

        <tbody>';



    foreach ($legalData as $row) {
        $balance = 0;
        $balance = $row['final_total_outstanding'] - $row['total_collection'];
    


$lastAction = $row['last_case_action'] ?? '-';
$lastDate   = $row['last_case_date'] ?? '-';
$shortAction = mb_strlen($lastAction) > 20 ? mb_substr($lastAction, 0, 20) . '...' : $lastAction;
$fullText = $lastAction . ' ' . $lastDate;


        echo '<tr style="border: 1px solid #00000014;">
      
          
           
<td style="border: 1px solid #00000014; max-width:150px; min-width:150px;"
    onclick="window.location=\'' . ROOT_DIR . 'activelegal/view/view/' . intval($row['id'] ?? 0) . '.html\'"
    style="cursor:pointer;">
   '. htmlspecialchars($row['User_Client'] ?? '-').'<br>
    <b>'. htmlspecialchars($row['Usertype_Client'] ?? '-').'</b><br>
    <span style="color: lightseagreen;">
       '. htmlspecialchars($row['code'] ?? '-').'
    </span>
</td>

            <td style="border: 1px solid #00000014; max-width:150px; min-width:150px; white-space: normal;word-break: break-word;">' . htmlspecialchars($row['ClientName'] ?? '-') . '<br>
              <b>' . htmlspecialchars($row['dateon'] ?? '-') . '</b></td>
           <td style="border: 1px solid #00000014; max-width:180px; min-width:140px; white-space:normal; word-wrap:break-word; overflow-wrap:break-word; text-align: justify;">' . htmlspecialchars($row['Present_Legal_Firm_Name'] ?? '-') . '</td>
            <td style="max-width:80px; min-width:80px;">' . htmlspecialchars($row['case_status'] ?? 'OPEN') . '</td>';
            if (defined('LEGAL_AUTH_EDIT') && LEGAL_AUTH_EDIT) {
        echo '     
            <td style="border: 1px solid #00000014; max-width:80px; min-width:80px;">
             <button type="button" class="btn btn-sm btn-primary"
        onclick="openLegalStatusModal(' . (int)$row['id'] . ', \'' . addslashes($row['legal_status']) . '\')">
        ' . htmlspecialchars($row['legal_status']) . '
    </button>
            </td>';
            } else {
                echo '<td style="border: 1px solid #00000014;">' . htmlspecialchars($row['legal_status'] ?? '-') . '</td>';
            }
            echo '
            <td style="border: 1px solid #00000014;">' . htmlspecialchars($row['final_total_outstanding'] ?? '-') . '</td>
            <td style="border: 1px solid #00000014;">' . htmlspecialchars($row['total_collection'] ?? '-') . '</td>
            <td style="border: 1px solid #00000014;">' . htmlspecialchars($balance ?? '-') . '</td>
            <td style="border: 1px solid #00000014;">' . htmlspecialchars($row['total_Expense'] ?? '-') . '</td>
      
      
      
<td style="max-width:100px; min-width:100px; position: relative; vertical-align: top;">
    <div class="hover-container">
        <div class="text-box" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
            '. htmlspecialchars($shortAction) .'<br>
            <small>'. htmlspecialchars($lastDate) .'</small>
        </div>

        <div class="full-content-tooltip">
            <b>'. htmlspecialchars($lastAction) .'</b><br>
            <small>'. htmlspecialchars($lastDate) .'</small>
        </div>
    </div>
</td>





   <td style="border: 1px solid #00000014;">
                <div class="btn-group">';
        if (defined('LEGAL_AUTH_VIEW') && LEGAL_AUTH_VIEW) {
            echo '
                    <a type="button" class="btn btn-success" href="' . ROOT_DIR . 'activelegal/view/view/' . intval($row['id'] ?? 0) . '.html' . '"><i class="lni lni-eye"></i></a>';
        }
        if (defined('LEGAL_AUTH_EDIT') && LEGAL_AUTH_EDIT) {
            echo '

                    <a type="button" href="' . ROOT_DIR . 'activelegal/information/edit/' . intval($row['id'] ?? 0) . '.html" class="btn btn-dark" title="Edit"><i class="fadeIn animated bx bx-pencil"></i></a>

                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#shiftingModal" data-legal_id="' . $row['id'] . '"><i class="lni lni-shuffle"></i></button>';
        }
        if (defined('LEGAL_AUTH_DELETE') && LEGAL_AUTH_DELETE) {
            echo '
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-legal_id="' . $row['id'] . '"><i class="lni lni-trash"></i></button>';
        }
        echo '
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
?>

<style>


.hover-container {
    position: relative;
    cursor: pointer;
}


.full-content-tooltip {
    display: none;
    position: absolute;
    z-index: 100;
    left: 0;
    top: 0;
    width: 100%;
    min-width: 300px;
    background-color: #ffffff;
    border: 1px solid #ccc;
    box-shadow: 0px 4px 10px rgba(0,0,0,0.2);
    padding: 10px;
    border-radius: 4px;
    color: #333;
    white-space: normal;
    word-wrap: break-word;
}


.hover-container:hover .full-content-tooltip {
    display: block;
}

</style>




<script>
document.addEventListener('DOMContentLoaded', function() {
    const boxes = document.querySelectorAll('.text-box');
    boxes.forEach(box => {
        box.style.height = box.scrollHeight + 'px';
    });
});
</script>