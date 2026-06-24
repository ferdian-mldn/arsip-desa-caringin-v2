<?php
$file = 'storage/app/templates/ket_domisili_-_ktp_-_terbaru_-_copy_(2)_-_copy_-_copy_-_copy.docx';
$zip = new ZipArchive;
$zip->open($file);
$xml = $zip->getFromName('word/document.xml');
$zip->close();

$original = $xml;

// Fix 1: "Nomor: Nomor: ${NOMOR_SURAT}" -> "Nomor: ${NOMOR_SURAT}"
// The "Nomor: " text was kept alongside our replacement. 
// The original text was '400.10.2.2/……/pemdes/2025' inside a cell that also has 'Nomor: '
// The original w:t was just the number part. Let's find where 'Nomor: ${NOMOR_SURAT}' appears twice
$xml = preg_replace('/Nomor: Nomor: \$\{NOMOR_SURAT\}/', 'Nomor: ${NOMOR_SURAT}', $xml);
echo "Fix 1: Nomor duplicate\n";

// Fix 2: MARPUDIN in halaman 1 (still hardcoded - was missed because search was 'MARPUDIN ')
// Find it in XML
$pos1 = strpos($xml, '>MARPUDIN<');
if ($pos1 !== false) {
    // Find the w:t tag
    $tagStart = strrpos(substr($xml, 0, $pos1), '<w:t');
    $tagEnd = strpos($xml, '</w:t>', $pos1) + 6;
    $origTag = substr($xml, $tagStart, $tagEnd - $tagStart);
    $attrs = '';
    if (preg_match('/^<w:t([^>]*)>/', $origTag, $am)) {
        $attrs = $am[1];
    }
    $newTag = '<w:t' . $attrs . '>${KEPALA_DESA}</w:t>';
    $xml = str_replace($origTag, $newTag, $xml);
    echo "Fix 2: MARPUDIN halaman 1 -> \${KEPALA_DESA}\n";
} else {
    echo "Fix 2: MARPUDIN not found (check 'MARPUDIN ')\n";
    // Try with space
    $pos1 = strpos($xml, '>MARPUDIN ');
    echo "  With space: " . ($pos1 !== false ? "found at $pos1" : "not found") . "\n";
}

// Fix 3: "M A R P U D I N" in halaman 1 (signature area)
// This is the stylized signature text - replace with ${KEPALA_DESA}
// It appears as "M A R P U D I N" spaced out
$xml = str_replace('M A R P U D I N', '${KEPALA_DESA}', $xml);
echo "Fix 3: M A R P U D I N -> \${KEPALA_DESA}\n";

// Fix 4: Agama bug on halaman 3 - "Agama: ${PEKERJAAN}"
// Find the pattern where Agama field incorrectly uses ${PEKERJAAN}
// We need to find the second occurrence of ${PEKERJAAN} that follows "Agama"
// In the XML, this would be within the same <w:tc> or nearby
// Strategy: find all occurrences and look at context
preg_match_all('/\$\{PEKERJAAN\}/', $xml, $pk, PREG_OFFSET_CAPTURE);
echo "\nFix 4: Found " . count($pk[0]) . " occurrences of \${PEKERJAAN}\n";

$agamaFixed = false;
foreach ($pk[0] as $occurrence) {
    $pkPos = $occurrence[1];
    $before = substr($xml, max(0, $pkPos - 300), 300);
    // Check if 'Agama' appears before this ${PEKERJAAN} without 'Pekerjaan' in between
    if (preg_match('/Agama[^P]*$/', $before) && !$agamaFixed) {
        echo "  -> Found Agama bug at pos $pkPos\n";
        // Replace this specific occurrence
        $xml = substr_replace($xml, '${AGAMA}', $pkPos, strlen('${PEKERJAAN}'));
        $agamaFixed = true;
        echo "  -> Fixed: Agama: \${PEKERJAAN} => Agama: \${AGAMA}\n";
    }
}

// Fix 5: "/ III / 2020" leftover in nomor surat halaman 3
$xml = str_replace(' / III / 2020 ', ' ', $xml);
echo "\nFix 5: Remove '/ III / 2020' leftover\n";

// Fix 6: EMAN HERMANSYAH,SE -> ${SEKRETARIS_DESA}
$xml = str_replace('EMAN HERMANSYAH,SE', '${SEKRETARIS_DESA}', $xml);
echo "Fix 6: EMAN HERMANSYAH,SE -> \${SEKRETARIS_DESA}\n";

// Save
$zip->open($file);
$zip->addFromString('word/document.xml', $xml);
$zip->close();
echo "\nAll fixes saved!\n";

// Verify
echo "\n=== VERIFICATION ===\n";
preg_match_all('/\${([^}]+)}/', $xml, $varMatches);
$vars = array_unique($varMatches[1]);
sort($vars);
echo "Variables now in template:\n";
foreach ($vars as $v) {
    echo "  \${$v}\n";
}
