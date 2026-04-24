<?php
ob_start();

session_start();

error_reporting(0);



include_once("../../../lib/config.php");

include_once("../../../lib/class/class.dbcon.php");

include_once("../../../lib/class/class.legal_active_legals.php");

include_once("../../../lib/class/class.legal_cheque.php");
$objCheque =   new Cheque();
include_once("../../../lib/class/class.legal_case_root_actions.php");
$objcaseRootAction = new CaseRootAction();


$objActiveLegal = new ActiveLegal();

include_once("../../../lib/class/class.legal_expense.php");
$objExpense = new Expense();
include_once("../../../lib/class/class.legal_collection.php");
$objCollection = new Collection();

$limit = PAGINATION_PERPAGE;



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
$search_filter['dateon'] = $fromDate;
$search_filter['search'] = $search;
$search_filter['user_id'] = $user_id;
$search_filter['client'] = $client;

// ✅ Fetch Total Records

$totalData = 0;

$countResult = $objActiveLegal->Get_LEGAL_TOTAL_COUNT('', '', 'A', 'Closed', $search_filter);

if (is_array($countResult) && isset($countResult[0]['TOTAL_RECORDS'])) {

    $totalData = (int)$countResult[0]['TOTAL_RECORDS'];
}



// ✅ Fetch Paginated Legal Data

$filters = [

    'status' => 'A',

    'legal_status' => 'Closed',

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


// ✅ Pagination Setup

$totalPage = max(1, ceil($totalData / $limit));

$start_page = max(1, $page_no - 5);

$end_page = min($totalPage, $start_page + 9);

$prev_val = max(1, $page_no - 1);

$next_val = min($totalPage, $page_no + 1);

// echo '<pre>';print_r($legalData);exit;



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

if ($totalData > 0 && is_array($legalData)) {

    echo '<table class="table align-middle mb-0">

        <thead class="table-light">

            <tr>

                <th>S/NO</th>

                <th>Client</th>

                <th>Case Status</th>

                <th>Present <br>Legal Firm</th>

                <th>Contact No</th>

                <th>Claim Amount</th>

                <th>Received Claim</th>

                <th>Expence</th>

                <th>Balance To Claim</th>

                <th>Last <br>Action & Date</th>

                <th>Remarks</th>


            </tr>

        </thead>

        <tbody>';

        $total_claim_amount = $all_totalCollection = $all_totalExpense = $allBalance = 0;
        foreach ($legalData as $key => $row) {
            $total_claim_amount += $row['final_total_outstanding'];
    
            $balance  = 0;
            $balance = $row['final_total_outstanding'] - $row['total_collection'];
    
            $all_totalCollection += $row['total_collection'];
            $all_totalExpense += $row['total_Expense'];
            $allBalance += $balance;

        echo '<tr>

          <td>' . ++$key . '</td>

            <td>' . htmlspecialchars($row['ClientName'] ?? '-') . '</td>

            <td>' . htmlspecialchars('Closed' ?? '-') . '</td>

            <td style="max-width:280px; min-width:240px; white-space:normal; word-wrap:break-word; overflow-wrap:break-word; text-align: justify;">' . htmlspecialchars($row['Present_Legal_Firm_Name'] ?? '-') . '</td>


            
            <td>' . htmlspecialchars($row['Clientmobile_number'] ?? '-') . '</td>
            <td>' . htmlspecialchars($row['final_total_outstanding'] ?? '-') . '</td>
         

            <td>' . htmlspecialchars($row['total_collection'] ?? '-') . '</td>
            <td>' . htmlspecialchars($row['total_Expense'] ?? '-') . '</td>
            <td>' . htmlspecialchars($balance ?? '-') . '</td>

            
            <td style="max-width:450px; min-width:350px; white-space:normal; word-wrap:break-word; overflow-wrap:break-word; text-align: justify;">' 
   . htmlspecialchars($row['last_case_action'] ?? '-') 
   . '<br><b>- ' 
   . htmlspecialchars($row['last_case_date'] ?? '-') 
   . '</b></td> 
            
            <td>' . htmlspecialchars('---') . '</td>


            

        </tr>
        
        ';
    }



    echo '<tr>
            <th class="text-center" width="10%" colspan="5">Total</th>
            <th class="text-left" width="10%">' . htmlspecialchars($total_claim_amount ?? '-') . '</th>
           <th class="text-left" width="10%">' . htmlspecialchars($all_totalCollection ?? '-') . '</th>
           <th class="text-left" width="10%">' . htmlspecialchars($all_totalExpense ?? '-') . '</th>
           <th class="text-left" width="10%">' . htmlspecialchars($allBalance ?? '-') . '</th>
            </tr></tbody></table>';
    } else {

    echo '<div style="width: 100%; text-align: center; padding: 50px 0; color: #ff0000; font-size: 20px;">

        No records found

    </div>';
}



// ✅ Render Pagination Only If Needed

if ($totalData > $limit) {

    echo $pagination_output;
}
