<?php
ob_start();
session_start();
date_default_timezone_set("Asia/Dubai");
include_once("../lib/config.php");
require '../vendor/autoload.php'; // PhpSpreadsheet Library

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
$keyword = $_GET['keyword'] ?? '';

// Prepare SQL Query
$sql = "SELECT name, code, address, contact_no, email FROM legal_firm WHERE legal_firm.status='A'";
$params = [];
$types = "";

// Keyword Search
if (!empty($keyword)) {
    $sql .= " AND (name LIKE ? OR code LIKE ? OR address LIKE ? OR contact_no LIKE ? OR email LIKE ?)";
    $keywordParam = "%$keyword%";
    $params = array_merge($params, array_fill(0, 5, $keywordParam));
    $types .= "sssss";
}
$sql .= " ORDER BY id DESC";
// Prepare and Execute Query
$stmt = $conn->prepare($sql);
if (!$stmt) {
    error_log("SQL Error: " . $conn->error);
    die("An error occurred. Please try again later.");
}

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

// Create Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Legal Firm');

// Set Headers
$headers = ["Name", "Code", "Address", "Contact No", "Email"];
$sheet->fromArray($headers, null, 'A1');

// Style Headers
$headerStyle = [
    'font' => ['bold' => true],
    'borders' => ['bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]]
];
$sheet->getStyle('A1:F1')->applyFromArray($headerStyle);

// Auto Column Width
foreach (range('A', 'F') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Fetch Data & Write to Excel
$rowNumber = 2; // Start writing from row 2
while ($row = $result->fetch_assoc()) {
    $sheet->fromArray(array_values($row), null, 'A' . $rowNumber);
    $rowNumber++;
}

// Send as Excel file
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="legal_firm_' . date("Y-m-d_H-i-s") . '.xlsx"');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

// Free Resources
$stmt->free_result();
$stmt->close();
$conn->close();
exit();
?>
