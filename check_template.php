<?php
$zip = new ZipArchive;
$file = 'storage/app/templates/sktm.docx';

if (!file_exists($file)) {
    echo "File not found: $file\n";
    echo "\nAvailable templates:\n";
    foreach (glob('storage/app/templates/*.docx') as $f) {
        echo "  - " . basename($f) . "\n";
    }
    exit;
}

$zip->open($file);
$xml = $zip->getFromName('word/document.xml');
$zip->close();

preg_match_all('/\${([^}]+)}/', $xml, $varMatches);
$vars = array_unique($varMatches[1]);
sort($vars);
echo "=== Variables found ===\n";
foreach ($vars as $v) { echo "  \${$v}\n"; }
echo "\nTotal: " . count($vars) . " unique variables\n";

$text = strip_tags($xml);
$text = preg_replace('/\s+/', ' ', $text);
echo "\n=== Document Text ===\n";
echo trim($text) . "\n";
