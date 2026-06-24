<?php
$zip = new ZipArchive;
$file = 'storage/app/templates/form._ktp.docx';

if ($zip->open($file) === TRUE) {
    $xml = $zip->getFromName('word/document.xml');
    
    // The user swapped KK and NIK. Let's swap them back.
    // We will replace NIK with TEMP, KK with NIK, and TEMP with KK.
    // Since my previous script cleaned the XML, they are exactly ${NIK_1} etc.
    
    $xml = preg_replace('/\$\{NIK_(\d+)\}/', '${TEMP_$1}', $xml);
    $xml = preg_replace('/\$\{KK_(\d+)\}/', '${NIK_$1}', $xml);
    $xml = preg_replace('/\$\{TEMP_(\d+)\}/', '${KK_$1}', $xml);
    
    $zip->addFromString('word/document.xml', $xml);
    $zip->close();
    echo "Swapped NIK and KK successfully.\n";
} else {
    echo "Failed to open zip\n";
}
