<?php
require __DIR__ . '/vendor/autoload.php';

$mdPath = __DIR__ . '/APPLICATION_DOCUMENTATION.md';
$pdfPath = __DIR__ . '/APPLICATION_DOCUMENTATION_PROFESSIONAL.pdf';
$tmpDir = __DIR__ . '/tmp/mpdf';

if (!is_dir($tmpDir)) {
    mkdir($tmpDir, 0777, true);
}

if (!file_exists($mdPath)) {
    fwrite(STDERR, "Markdown file not found: $mdPath\n");
    exit(1);
}

$md = file_get_contents($mdPath);

function inlineFormat($text)
{
    $text = htmlspecialchars($text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    $text = preg_replace('/`([^`]+)`/', '<code>$1</code>', $text);
    $text = preg_replace('/\*\*([^*]+)\*\*/', '<strong>$1</strong>', $text);
    return $text;
}

function markdownToHtml($md)
{
    $lines = preg_split('/\r\n|\r|\n/', $md);
    $html = '';
    $inUl = false;
    $inOl = false;

    foreach ($lines as $line) {
        $trim = trim($line);

        if ($trim === '') {
            if ($inUl) {
                $html .= "</ul>\n";
                $inUl = false;
            }
            if ($inOl) {
                $html .= "</ol>\n";
                $inOl = false;
            }
            $html .= "<div class='spacer'></div>\n";
            continue;
        }

        if (preg_match('/^---+$/', $trim)) {
            if ($inUl) { $html .= "</ul>\n"; $inUl = false; }
            if ($inOl) { $html .= "</ol>\n"; $inOl = false; }
            $html .= "<hr/>\n";
            continue;
        }

        if (preg_match('/^#\s+(.+)$/', $trim, $m)) {
            if ($inUl) { $html .= "</ul>\n"; $inUl = false; }
            if ($inOl) { $html .= "</ol>\n"; $inOl = false; }
            $html .= '<h1>' . inlineFormat($m[1]) . "</h1>\n";
            continue;
        }

        if (preg_match('/^##\s+(.+)$/', $trim, $m)) {
            if ($inUl) { $html .= "</ul>\n"; $inUl = false; }
            if ($inOl) { $html .= "</ol>\n"; $inOl = false; }
            $html .= '<h2>' . inlineFormat($m[1]) . "</h2>\n";
            continue;
        }

        if (preg_match('/^###\s+(.+)$/', $trim, $m)) {
            if ($inUl) { $html .= "</ul>\n"; $inUl = false; }
            if ($inOl) { $html .= "</ol>\n"; $inOl = false; }
            $html .= '<h3>' . inlineFormat($m[1]) . "</h3>\n";
            continue;
        }

        if (preg_match('/^\-\s+(.+)$/', $trim, $m)) {
            if ($inOl) { $html .= "</ol>\n"; $inOl = false; }
            if (!$inUl) {
                $html .= "<ul>\n";
                $inUl = true;
            }
            $html .= '<li>' . inlineFormat($m[1]) . "</li>\n";
            continue;
        }

        if (preg_match('/^\d+\.\s+(.+)$/', $trim, $m)) {
            if ($inUl) { $html .= "</ul>\n"; $inUl = false; }
            if (!$inOl) {
                $html .= "<ol>\n";
                $inOl = true;
            }
            $html .= '<li>' . inlineFormat($m[1]) . "</li>\n";
            continue;
        }

        if ($inUl) { $html .= "</ul>\n"; $inUl = false; }
        if ($inOl) { $html .= "</ol>\n"; $inOl = false; }

        if (preg_match('/^\*\*(.+)\*\*\s*$/', $trim, $m)) {
            $html .= '<p class="meta"><strong>' . inlineFormat($m[1]) . "</strong></p>\n";
        } else {
            $html .= '<p>' . inlineFormat($trim) . "</p>\n";
        }
    }

    if ($inUl) $html .= "</ul>\n";
    if ($inOl) $html .= "</ol>\n";

    return $html;
}

$body = markdownToHtml($md);
$dateStr = date('F d, Y');

$html = "<!doctype html>
<html>
<head>
<meta charset='UTF-8'>
<style>
body { font-family: dejavusans, sans-serif; color: #1f2a37; font-size: 10.5pt; line-height: 1.55; }
h1 { font-size: 23pt; color: #0f4c81; margin: 18pt 0 10pt; border-bottom: 1px solid #dbe7f3; padding-bottom: 8pt; }
h2 { font-size: 16pt; color: #145c9e; margin: 16pt 0 8pt; }
h3 { font-size: 13pt; color: #1f2a37; margin: 14pt 0 6pt; }
p { margin: 0 0 8pt 0; }
.meta { color: #4b5563; }
ul, ol { margin: 0 0 10pt 20pt; padding: 0; }
li { margin-bottom: 4pt; }
code { font-family: dejavusansmono, monospace; font-size: 9pt; background: #f3f4f6; color: #0b3a66; padding: 2pt 4pt; border-radius: 3px; }
hr { border: 0; border-top: 1px solid #d1d5db; margin: 12pt 0; }
.spacer { height: 2pt; }
.cover { text-align: center; padding-top: 180pt; }
.cover h1 { border: 0; margin-bottom: 12pt; font-size: 30pt; color: #0f4c81; }
.cover p { font-size: 12pt; color: #4b5563; }
</style>
</head>
<body>
<div class='cover'>
<h1>Tabasco Legal Management System</h1>
<p>Full Application Documentation</p>
<p>Generated on {$dateStr}</p>
</div>
<pagebreak />
{$body}
</body>
</html>";

$mpdf = new \Mpdf\Mpdf([
    'tempDir' => $tmpDir,
    'mode' => 'utf-8',
    'format' => 'A4',
    'margin_left' => 16,
    'margin_right' => 16,
    'margin_top' => 18,
    'margin_bottom' => 16,
    'margin_header' => 8,
    'margin_footer' => 8,
]);

$mpdf->SetTitle('Tabasco Legal - Full Documentation');
$mpdf->SetAuthor('Tabasco Legal Team');
$mpdf->SetSubject('Application Documentation');
$mpdf->SetCreator('Tabasco Legal System');
$mpdf->SetDisplayMode('fullpage');
$mpdf->SetHTMLHeader("<div style='font-size:9pt;color:#6b7280;border-bottom:1px solid #e5e7eb;padding-bottom:3pt;'>Tabasco Legal Management System Documentation</div>");
$mpdf->SetHTMLFooter("<div style='font-size:9pt;color:#6b7280;border-top:1px solid #e5e7eb;padding-top:3pt;text-align:right;'>Page {PAGENO}</div>");
$mpdf->WriteHTML($html);
$mpdf->Output($pdfPath, \Mpdf\Output\Destination::FILE);

echo "Generated: $pdfPath\n";
?>
