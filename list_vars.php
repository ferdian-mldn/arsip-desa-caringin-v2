<?php
$zip = new ZipArchive;
$zip->open('storage/app/templates/form._ktp.docx');
$xml = $zip->getFromName('word/document.xml');
$zip->close();

// Extract all ${...} variables from the XML
preg_match_all('/\${([^}]+)}/', $xml, $matches);
$vars = array_unique($matches[1]);
sort($vars);
echo "Variables found in template:\n";
foreach ($vars as $v) {
    echo "  " . $v . "\n";
}
echo "\nTotal: " . count($vars) . " unique vars\n";
