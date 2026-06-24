<?php
$zip = new ZipArchive;
$zip->open('storage/app/templates/form._ktp.docx');
$xml = $zip->getFromName('word/document.xml');
if (preg_match('/<w:tc[^>]*>.*?NAMA_1.*?<\/w:tc>/s', $xml, $m)) {
    echo "Found NAMA_1 cell:\n";
    echo $m[0] . "\n";
} else {
    echo "NAMA_1 not found\n";
}
$zip->close();
