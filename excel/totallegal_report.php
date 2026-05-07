<?php

ob_start();
session_start();

date_default_timezone_set("Asia/Dubai");

error_reporting(E_ALL);

include_once("../lib/config.php");
include_once("../lib/class/class.dbcon.php");
include_once("../lib/class/class.legal_active_legals.php");

require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Border;

/* =========================================================
   OBJECTS
========================================================= */

$objActiveLegal = new ActiveLegal();

/* =========================================================
   DB CONNECTION
========================================================= */

$conn = new mysqli(IP, USER, DBPWD, DB);

if ($conn->connect_error) {
    die("Database connection failed");
}

/* =========================================================
   GET FILTERS
========================================================= */

$select_case_id =
    trim($_GET['select_case_id'] ?? '');

$select_client_id =
    trim($_GET['select_client_id'] ?? '');

/* =========================================================
   FILTER ARRAY
========================================================= */

$filters = [

    'status' => 'A',

    'legal_status' => 'Total',

    'client' => $select_client_id,

    'case_id' => $select_case_id
];

/* =========================================================
   FETCH DATA
========================================================= */

$legalData =
    $objActiveLegal->Get_ActiveLegal_Information($filters);

/* =========================================================
   LOAD CLASSES
========================================================= */

include_once("../lib/class/class.legal_expense.php");
$objExpense = new Expense();

include_once("../lib/class/class.legal_collection.php");
$objCollection = new Collection();

include_once("../lib/class/class.legal_cheque.php");
$objCheque = new Cheque();

include_once("../lib/class/class.legal_case_root_actions.php");
$objcaseRootAction = new CaseRootAction();

/* =========================================================
   CREATE EXCEL
========================================================= */

$spreadsheet = new Spreadsheet();

$sheet = $spreadsheet->getActiveSheet();

$sheet->setTitle('Total Legal');

/* =========================================================
   HEADER
========================================================= */

$headers = [

    "S/NO",
    "Client",
    "Case Status",
    "Present Legal Firm",
    "Contact No",
    "Claim Amount",
    "Received Claim",
    "Expense",
    "Balance To Claim",
    "Last Action & Date",
    "Remarks"
];

$sheet->fromArray($headers, null, 'A1');

/* =========================================================
   STYLE
========================================================= */

$headerStyle = [

    'font' => [
        'bold' => true,
        'size' => 11
    ],

    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN
        ]
    ]
];

$sheet->getStyle('A1:K1')->applyFromArray($headerStyle);

/* =========================================================
   AUTO WIDTH
========================================================= */

foreach (range('A', 'K') as $col) {

    $sheet->getColumnDimension($col)->setAutoSize(true);
}

/* =========================================================
   DATA
========================================================= */

$dataRows = [];

if (!empty($legalData)) {

    $slno = 1;

    foreach ($legalData as $row) {

        /* =========================
           CHEQUE TOTAL
        ========================= */

        $with_client =
            $objCheque->get_cheque_total($row['client'], 'C');

        $wit_case =
            $objCheque->get_cheque_total($row['client'], 'CA');

        $with_client_total1 =
            isset($with_client[0]['Total1'])
            ? (float)$with_client[0]['Total1']
            : 0;

        $with_client_total2 =
            isset($with_client[0]['Total2'])
            ? (float)$with_client[0]['Total2']
            : 0;

        $wit_case_total1 =
            isset($wit_case[0]['Total1'])
            ? (float)$wit_case[0]['Total1']
            : 0;

        $wit_case_total2 =
            isset($wit_case[0]['Total2'])
            ? (float)$wit_case[0]['Total2']
            : 0;

        $outstanding_cheque =
            $with_client_total1 + $wit_case_total1;

        $outstanding_without_cheque =
            $with_client_total2 + $wit_case_total2;

        $total_outstanding =
            $outstanding_cheque + $outstanding_without_cheque;

        /* =========================
           COLLECTION
        ========================= */

        $total_collection =
            (float)$objCollection->total_collection($row['id']);

        /* =========================
           EXPENSE
        ========================= */

        $total_expense =
            (float)$objExpense->total_expense($row['id']);

        /* =========================
           BALANCE
        ========================= */

        $balance =
            $total_outstanding - $total_collection;

        /* =========================
           LAST ACTION
        ========================= */

        $lastAction = '-';

        $case_filter = [

            'created_from' => 'CA',

            'active_legal_id' => $row['id']
        ];

        $case_roots =
            $objcaseRootAction->get_case_root('', $case_filter);

        if (!empty($case_roots[0])) {

            $description =
                $case_roots[0]['description'] ?? '';

            $date =
                $case_roots[0]['date'] ?? '';

            $lastAction =
                trim($description . ' ' . $date);
        }

        /* =========================
           ROW DATA
        ========================= */

        $dataRows[] = [

            $slno++,

            $row['ClientName'] ?? '-',

            $row['case_status'] ?? '-',

            $row['Present_Legal_Firm_Name'] ?? '-',

            $row['Clientmobile_number'] ?? '-',

            number_format($total_outstanding, 2),

            number_format($total_collection, 2),

            number_format($total_expense, 2),

            number_format($balance, 2),

            $lastAction,

            $row['remarks'] ?? '-'
        ];
    }
}

/* =========================================================
   INSERT DATA
========================================================= */

if (!empty($dataRows)) {

    $sheet->fromArray($dataRows, null, 'A2');
}

/* =========================================================
   DOWNLOAD
========================================================= */

$fileName =
    "total_legal_report_" .
    date("Y-m-d_H-i-s") .
    ".xls";

header('Content-Type: application/vnd.ms-excel');

header(
    'Content-Disposition: attachment; filename="' .
    $fileName .
    '"'
);

header('Cache-Control: max-age=0');

$writer = new Xls($spreadsheet);

$writer->save('php://output');

/* =========================================================
   CLOSE
========================================================= */

$conn->close();

exit();

?>