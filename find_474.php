<?php
$file = 'storage/app/templates/sku_new.docx';
$zip = new ZipArchive;
$zip->open($file);
$xml = $zip->getFromName('word/document.xml');
$zip->close();

// Find exact context of 474.1
$pos = strpos($xml, '474.1');
$context = substr($xml, max(0, $pos - 200), 600);
echo "Context around 474.1:\n";
echo strip_tags($context) . "\n\n";
echo "---RAW---\n";
echo $context . "\n";
