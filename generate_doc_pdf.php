<?php
require __DIR__ . '/vendor/autoload.php';

$mdPath = __DIR__ . '/APPLICATION_DOCUMENTATION.md';
$pdfPath = __DIR__ . '/APPLICATION_DOCUMENTATION.pdf';

if (!file_exists($mdPath)) {
    fwrite(STDERR, "Markdown file not found: $mdPath\n");
    exit(1);
}

$md = file_get_contents($mdPath);

$escaped = htmlspecialchars($md, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
$html = '<!doctype html><html><head><meta charset="UTF-8"><style>
body{font-family: sans-serif; font-size: 10pt;}
pre{white-space: pre-wrap; word-wrap: break-word; font-family: monospace; font-size: 9pt;}
</style></head><body><pre>' . $escaped . '</pre></body></html>';

$mpdf = new \Mpdf\Mpdf([
    'tempDir' => __DIR__ . '/tmp/mpdf',
    'mode' => 'utf-8',
    'format' => 'A4',
    'margin_left' => 12,
    'margin_right' => 12,
    'margin_top' => 12,
    'margin_bottom' => 12,
]);

$mpdf->SetTitle('Tabasco Legal Documentation');
$mpdf->WriteHTML($html);
$mpdf->Output($pdfPath, \Mpdf\Output\Destination::FILE);

echo "Generated: $pdfPath\n";
?>


