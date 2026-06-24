<?php
$file = 'storage/app/templates/sku_new.docx';
$zip = new ZipArchive;
$zip->open($file);
$xml = $zip->getFromName('word/document.xml');
$zip->close();

// Fix remaining 474.1 leftover
$xml = preg_replace('/474\.1\s*\/[^<]*/', '${NOMOR_SURAT}', $xml);

$zip->open($file);
$zip->addFromString('word/document.xml', $xml);
$zip->close();

echo "474.1 check: " . (strpos($xml, '474.1') !== false ? "STILL PRESENT!" : "cleaned") . "\n";
echo "Done!\n";
