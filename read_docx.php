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
    $text = strip_tags(str_replace(['<w:p', '</w:p>'], ["\n", "\n"], $xml));
    $text = preg_replace("/\n+/", "\n", $text); // Remove empty lines
    file_put_contents('c:\\laragon\\www\\arsip desa v2\\desav2\\extracted_profil.txt', $text);
    echo "Extracted to extracted_profil.txt";
} else {
    echo 'Failed to open zip file.';
}
