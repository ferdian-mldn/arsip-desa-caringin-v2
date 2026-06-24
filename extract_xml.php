<?php
$zip = new ZipArchive;
$res = $zip->open('storage/app/templates/form._ktp.docx');
if ($res === TRUE) {
    file_put_contents('ktp_xml.txt', $zip->getFromName('word/document.xml'));
    $zip->close();
    echo "Extracted successfully";
} else {
    echo "Failed to open zip";
}
