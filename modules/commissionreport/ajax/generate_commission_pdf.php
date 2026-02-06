<?php
// IMPORTANT: show errors while testing
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

/* ===============================
   GET DATA FROM AJAX
================================ */
$rows = $_POST['rows'] ?? [];

if (empty($rows)) {
    exit('No data selected');
}

/* ===============================
   CREATE SPREADSHEET
================================ */
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

/* ===============================
   PAGE SETUP
================================ */
$sheet->getPageSetup()
    ->setOrientation(PageSetup::ORIENTATION_PORTRAIT)
    ->setPaperSize(PageSetup::PAPERSIZE_A4);

/* ===============================
   TITLE
================================ */
$sheet->setCellValue('A1', 'Commission Report');
$sheet->mergeCells('A1:D1');
$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
$sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

/* ===============================
   TABLE HEADER
================================ */
$sheet->setCellValue('A3', 'Party');
$sheet->setCellValue('B3', 'Received Collection');
$sheet->setCellValue('C3', 'Commission (%)');
$sheet->setCellValue('D3', 'Commission Payable');

$sheet->getStyle('A3:D3')->getFont()->setBold(true);

/* ===============================
   TABLE DATA
================================ */
$rowNum = 4;
$totalReceived = 0;
$totalPayable  = 0;

foreach ($rows as $r) {

    $received = floatval($r['received']);
    $payable  = floatval($r['payable']);

    $totalReceived += $received;
    $totalPayable  += $payable;

    $sheet->setCellValue("A$rowNum", $r['party']);
    $sheet->setCellValue("B$rowNum", number_format($received, 2));
    $sheet->setCellValue("C$rowNum", $r['commission']);
    $sheet->setCellValue("D$rowNum", number_format($payable, 2));

    $rowNum++;
}

/* ===============================
   TOTAL ROW
================================ */
$sheet->getStyle("A$rowNum:D$rowNum")->getFont()->setBold(true);

$sheet->setCellValue("A$rowNum", 'Total');
$sheet->setCellValue("B$rowNum", number_format($totalReceived, 2));
$sheet->setCellValue("D$rowNum", number_format($totalPayable, 2));

/* ===============================
   SIGNING SECTION
================================ */
$rowNum += 3;
$sheet->setCellValue("A$rowNum", 'Processed By: ______________________________');

$rowNum += 2;
$sheet->setCellValue("A$rowNum", 'Completed For Signing: ______________________________');

/* ===============================
   AUTO SIZE COLUMNS
================================ */
foreach (['A','B','C','D'] as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

/* ===============================
   OUTPUT PDF
================================ */
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="Commission_Report.pdf"');
header('Cache-Control: max-age=0');

$writer = new Mpdf($spreadsheet);
$writer->save('php://output');
exit;
