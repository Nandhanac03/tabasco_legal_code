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

// Enable error logging
ini_set('log_errors', 1);
ini_set('error_log', 'errors.log');
error_reporting(E_ALL);

// Database Connection
$conn = new mysqli(IP, USER, DBPWD, DB);
if ($conn->connect_error) {
    error_log("Database Connection Failed: " . $conn->connect_error);
    die("Database connection error. Please try again later.");
}

// Get Filters
$select_case_id   = trim($_GET['select_case_id'] ?? '');
$select_client_id = trim($_GET['select_client_id'] ?? '');

// Prepare SQL Query
$filters = [
    'status' => 'A',
    'legal_status' => 'Active',
    'case_id' => $select_case_id,
    'client' => $select_client_id
];

$legalData = $objActiveLegal->Get_ActiveLegal_Information($filters);

// Create Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Collection & Expense');

// Set Headers
$headers = ["Date", "Marketing", "Client", "Present Legal Firm"];
$sheet->fromArray($headers, null, 'A1');

// Style Headers
$headerStyle = [
    'font' => ['bold' => true],
    'borders' => ['bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]]
];
$sheet->getStyle('A1:D1')->applyFromArray($headerStyle);

// Auto Column Width
foreach (range('A', 'D') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

$dataRows = [];
if ($legalData) {
    foreach ($legalData as $row) {
        $dataRows[] = [
            $row['dateon'] ?? '-',
            ($row['User_Client'] ?? '-') . ' (' . ($row['Usertype_Client'] ?? '-') . ')',
            $row['ClientName'] ?? '-',
            $row['Present_Legal_Firm_Name'] ?? '-'
        ];
    }
}

if (!empty($dataRows)) {
    $sheet->fromArray($dataRows, null, 'A2');
}

// Send as Excel file
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="collection_expense_report_' . date("Y-m-d_H-i-s") . '.xls"');

$writer = new Xls($spreadsheet);
$writer->save('php://output');

$conn->close();
exit();
?>
