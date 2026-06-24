<?php
$file = 'c:\\laragon\\www\\arsip desa v2\\desav2\\asset\\desa\\PROFIL DESA CARINGIN BARU PISAN 2025.docx';
if (!file_exists($file)) {
    echo "File not found: " . $file . "\n";
    exit(1);
}
$zip = new ZipArchive;
if ($zip->open($file) === TRUE) {
    $xml = $zip->getFromName('word/document.xml');
    $zip->close();
    
    $doc = new DOMDocument();
    $doc->loadXML($xml);
    $texts = $doc->getElementsByTagName('t');
    
    $output = '';
    foreach ($texts as $text) {
        $output .= $text->nodeValue . ' ';
    }
    
    file_put_contents('c:\\laragon\\www\\arsip desa v2\\desav2\\extracted_profil_clean.txt', $output);
    echo "Extracted cleanly to extracted_profil_clean.txt";
} else {
    echo 'Failed to open zip file.';
}
