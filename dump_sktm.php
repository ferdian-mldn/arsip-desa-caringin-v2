<?php
$file = 'storage/app/templates/sktm.docx';
$zip = new ZipArchive;
$zip->open($file);
$xml = $zip->getFromName('word/document.xml');
$zip->close();

// Get all text nodes with positions
preg_match_all('/<w:t([^>]*)>([^<]+)<\/w:t>/', $xml, $matches, PREG_OFFSET_CAPTURE);

echo "=== All text nodes ===\n";
foreach ($matches[0] as $i => $m) {
    $text = $matches[2][$i][0];
    echo "  [$i] '" . substr($text, 0, 80) . "'\n";
}
