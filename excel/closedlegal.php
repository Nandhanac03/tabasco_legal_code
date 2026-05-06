<?php
ob_start();
session_start();
date_default_timezone_set("Asia/Dubai");
include_once("../lib/config.php");
include_once("../lib/class/class.dbcon.php");
include_once("../lib/class/class.legal_active_legals.php");
require '../vendor/autoload.php'; // PhpSpreadsheet Library

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

$objActiveLegal = new ActiveLegal();



// Database Connection
$conn = new mysqli(IP, USER, DBPWD, DB);
if ($conn->connect_error) {
    error_log("Database Connection Failed: " . $conn->connect_error);
    die("Database connection error. Please try again later.");
}

// Get Filters
$search           = trim($_GET['search_code'] ?? $_GET['search'] ?? '');
$select_case_id   = trim($_GET['select_case_id'] ?? '');
$select_client_id = trim($_GET['select_client_id'] ?? $_GET['client'] ?? '');
$fromDate         = preg_match('/^\d{4}-\d{2}-\d{2}$/', $_GET['fromDate'] ?? $_GET['fromdate'] ?? '') ? ($_GET['fromDate'] ?? $_GET['fromdate']) : '';

// Prepare SQL Query
$filters = [
    'status' => 'A',
    'legal_status' => 'Closed', // Hardcoded for this file
    'dateon' => $fromDate,
    'search' => $search,
    'client' => $select_client_id,
    'case_id' => $select_case_id
];

$legalData = $objActiveLegal->Get_ActiveLegal_Information($filters);

// Create Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Closed Legal');

// Set Headers
$headers = ["Code", "Date", "Marketing", "Client", "Present Legal Firm", "Case Status", "Claim Amount", "Collection Received", "Balance to Claim", "Expense"];
$sheet->fromArray($headers, null, 'A1');

// Style Headers
$headerStyle = [
    'font' => ['bold' => true],
    'borders' => ['bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]]
];
$sheet->getStyle('A1:J1')->applyFromArray($headerStyle);

// Auto Column Width
foreach (range('A', 'J') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

$dataRows = [];
if ($legalData) {
    include_once("../lib/class/class.legal_expense.php");
    $objExpense = new Expense();
    include_once("../lib/class/class.legal_collection.php");
    $objCollection = new Collection();
    include_once("../lib/class/class.legal_cheque.php");
    $objCheque = new Cheque();

    foreach ($legalData as $row) {
        // Financial Calculations
        $with_client = $objCheque->get_cheque_total($row['client'], 'C');
        $wit_case    = $objCheque->get_cheque_total($row['client'], 'CA');
        $with_client_total1 = isset($with_client[0]['Total1']) ? (float)$with_client[0]['Total1'] : 0;
        $with_client_total2 = isset($with_client[0]['Total2']) ? (float)$with_client[0]['Total2'] : 0;
        $wit_case_total1 = isset($wit_case[0]['Total1']) ? (float)$wit_case[0]['Total1'] : 0;
        $wit_case_total2 = isset($wit_case[0]['Total2']) ? (float)$wit_case[0]['Total2'] : 0;
        
        $outstanding_cheque         = $with_client_total1 + $wit_case_total1;
        $outstanding_without_cheque = $with_client_total2 + $wit_case_total2;
        $total_outstanding          = $outstanding_cheque + $outstanding_without_cheque;
        
        $total_collection = $objCollection->total_collection($row['id']);
        $balance = $total_outstanding - $total_collection;
        $total_expense = $objExpense->total_expense($row['id']);

        $dataRows[] = [
            $row['code'] ?? '-',
            $row['dateon'] ?? '-',
            ($row['User_Client'] ?? '-') . ' (' . ($row['Usertype_Client'] ?? '-') . ')',
            $row['ClientName'] ?? '-',
            $row['Present_Legal_Firm_Name'] ?? '-',
            $row['case_status'] ?? 'Closed',
            number_format($total_outstanding, 2),
            number_format($total_collection, 2),
            number_format($balance, 2),
            number_format($total_expense, 2)
        ];
    }
}

if (!empty($dataRows)) {
    $sheet->fromArray($dataRows, null, 'A2');
}

// Send as Excel file
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="closed_legal_report_' . date("Y-m-d_H-i-s") . '.xls"');

$writer = new Xls($spreadsheet);
$writer->save('php://output');

$conn->close();
exit();
?>
