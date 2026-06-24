<?php
$file = 'storage/app/templates/ket_domisili_-_ktp_-_terbaru_-_copy_(2)_-_copy_-_copy_-_copy.docx';
$zip = new ZipArchive;
$zip->open($file);
file_put_contents('domisili_xml.txt', $zip->getFromName('word/document.xml'));
$zip->close();
echo "done\n";
