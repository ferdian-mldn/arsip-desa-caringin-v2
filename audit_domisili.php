<?php
// Comprehensive fix script for domisili KTP template
$file = 'storage/app/templates/ket_domisili_-_ktp_-_terbaru_-_copy_(2)_-_copy_-_copy_-_copy.docx';
$zip = new ZipArchive;
$zip->open($file);
$xml = $zip->getFromName('word/document.xml');
$zip->close();

// =============================================
// We need to find ALL hardcoded text in w:t tags
// and list them for review + replacement
// =============================================
preg_match_all('/<w:t[^>]*>([^<]+)<\/w:t>/', $xml, $matches, PREG_OFFSET_CAPTURE);

echo "=== All text nodes ===\n";
foreach ($matches[1] as $i => $m) {
    $text = $m[0];
    $pos  = $m[1];
    // Highlight suspicious hardcoded text (numbers, months, names)
    if (preg_match('/\d{4}|September|Maret|Mei|Januari|Februari|April|Juni|Juli|Agustus|Oktober|November|Desember|MARPUDIN|NANANG|474|478|400|Agama.*PEKERJAAN/i', $text)) {
        echo "  [$i] pos=$pos *** '$text' ***\n";
    }
}

// Also look for patterns in combined text
echo "\n\n=== Pekerjaan bug check ===\n";
preg_match_all('/Agama[^<]*\$\{([^}]+)\}/', $xml, $m2);
foreach ($m2[0] as $found) {
    echo "  Found: " . strip_tags($found) . "\n";
}
