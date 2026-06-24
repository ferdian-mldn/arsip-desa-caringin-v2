<?php
$file = 'storage/app/templates/ket_domisili_-_ktp_-_terbaru_-_copy_(2)_-_copy_-_copy_-_copy.docx';
$zip = new ZipArchive;
$zip->open($file);
$xml = $zip->getFromName('word/document.xml');
$zip->close();

// Fix MARPUDIN with space
$pos = strpos($xml, 'MARPUDIN ');
if ($pos !== false) {
    $tagStart = strrpos(substr($xml, 0, $pos), '<w:t');
    $tagEnd = strpos($xml, '</w:t>', $pos) + 6;
    $origTag = substr($xml, $tagStart, $tagEnd - $tagStart);
    $newTag = preg_replace('/(<w:t[^>]*>).*(<\/w:t>)/s', '$1${KEPALA_DESA}$2', $origTag);
    $xml = str_replace($origTag, $newTag, $xml);
    echo "Fixed MARPUDIN -> \${KEPALA_DESA}\n";
}

// Fix Agama bug - find ${PEKERJAAN} after Agama
preg_match_all('/\$\{PEKERJAAN\}/', $xml, $pk, PREG_OFFSET_CAPTURE);
$agamaFixed = false;
foreach ($pk[0] as $occurrence) {
    $pkPos = $occurrence[1];
    $before = substr($xml, max(0, $pkPos - 500), 500);
    if (preg_match('/Agama[^}]*$/', $before) && !$agamaFixed) {
        $xml = substr_replace($xml, '${AGAMA}', $pkPos, strlen('${PEKERJAAN}'));
        $agamaFixed = true;
        echo "Fixed Agama bug\n";
    }
}

// Save
$zip->open($file);
$zip->addFromString('word/document.xml', $xml);
$zip->close();
echo "Saved!\n";

// Final verification
preg_match_all('/\${([^}]+)}/', $xml, $varMatches);
$vars = array_unique($varMatches[1]);
sort($vars);
echo "\nFinal variables in template:\n";
foreach ($vars as $v) { echo "  \${$v}\n"; }

// Check if MARPUDIN or Agama bug still exists
echo "\nMARPUDIN still present: " . (strpos($xml, 'MARPUDIN') !== false ? 'YES (problem!)' : 'NO (good)') . "\n";
echo "M A R P U D I N still present: " . (strpos($xml, 'M A R P U D I N') !== false ? 'YES (problem!)' : 'NO (good)') . "\n";

// Check Agama field
preg_match_all('/Agama[^<]*<[^>]*>[^<]*<\/[^>]*>[^<]*<\/[^>]*>\s*\$\{([^}]+)\}/', $xml, $check);
echo "Agama fields: ";
foreach ($check[1] as $c) { echo "\${$c} "; }
echo "\n";
