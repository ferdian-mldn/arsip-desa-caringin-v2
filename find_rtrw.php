<?php
$zip = new ZipArchive;
$zip->open('storage/app/templates/form._ktp.docx');
$xml = $zip->getFromName('word/document.xml');
$zip->close();

// Find cells containing 0, 2, 6 (RT) and 0, 0, 7 (RW)
// These are likely after the RT RW label cells
// Let's find the section around RT / RW text
$pos = strpos($xml, 'R T');
if ($pos === false) $pos = strpos($xml, '>R<');
echo "Found 'R T' at pos: $pos\n";

// Extract a chunk of XML around RT/RW rows
$chunk = substr($xml, $pos - 100, 3000);
// Strip all tags to see just text
$text = strip_tags($chunk);
$text = preg_replace('/\s+/', ' ', $text);
echo "TEXT AROUND RT/RW: $text\n";
echo "\n\n--- RAW XML CHUNK ---\n";
echo $chunk;
