<?php
ob_start();
session_start();
date_default_timezone_set("Asia/Dubai");
include_once("../lib/config.php");
include_once("../lib/class/class.dbcon.php");
include_once("../lib/class/class.legal_active_legals.php");
require '../vendor/autoload.php'; // PhpSpreadsheet Library

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
// ✅ Sanitize Input
$marketing  = trim($_GET['marketing'] ?? '');
$client     = trim($_GET['client'] ?? '');
$fromDate   = preg_match('/^\d{4}-\d{2}-\d{2}$/', $_GET['fromDate'] ?? '') ? $_GET['fromDate'] : '';
$toDate     = preg_match('/^\d{4}-\d{2}-\d{2}$/', $_GET['toDate'] ?? '') ? $_GET['toDate'] : '';
$keyword    = htmlspecialchars(strip_tags(trim($_GET['keyword'] ?? '')));
$keyword = $_GET['keyword'] ?? '';

// Prepare SQL Query
$filters = [
    'status' => 'A',
    // You can also add 'fromDate', 'toDate', 'marketing', etc., if your method supports filtering
];
$legalData = $objActiveLegal->Get_ActiveLegal_Information($filters);

// Create Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Debt Collector');

// Set Headers
$headers = ["Code", "Date", "Marketing", "Client", "Present Legal Firm", "Case Status", "Claim Amount", "Received Claim", "Balance to Claim", "Expense"];
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
foreach ($legalData as $data) {
    array_push($dataRows, [$data['code'], $data['dateon'], "{$data['User_Client']}({$data['Usertype_Client']})", $data['ClientName'], $data['Present_Legal_Firm_Name'], $data['case_status'] ?? 'Open', $data['claim_amount'], $data['balance_claim'], $data['expense_amount'], "----",]);
}

$rowNumber = 2;
foreach ($dataRows as $row) {
    $sheet->fromArray($row, null, 'A' . $rowNumber++);
}

// Send as Excel file
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="legal_activelegal_' . date("Y-m-d_H-i-s") . '.xlsx"');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

// Free Resources
$stmt->free_result();
$stmt->close();
$conn->close();
exit();
