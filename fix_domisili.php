<?php
// Comprehensive fix for ket_domisili template
// Fixes all hardcoded text → variables

$file = 'storage/app/templates/ket_domisili_-_ktp_-_terbaru_-_copy_(2)_-_copy_-_copy_-_copy.docx';
$zip = new ZipArchive;
$zip->open($file);
$xml = $zip->getFromName('word/document.xml');
$zip->close();

// Get all text nodes with positions for targeted replacements
preg_match_all('/<w:t([^>]*)>([^<]+)<\/w:t>/', $xml, $matches, PREG_OFFSET_CAPTURE);

$ops = []; // [position_in_xml, original_full_tag, new_full_tag]

foreach ($matches[0] as $i => $m) {
    $fullTag = $m[0];     // <w:t...>TEXT</w:t>
    $pos     = $m[1];     // position in XML
    $attrs   = $matches[1][$i][0];
    $text    = $matches[2][$i][0];

    $newText = null;

    // Fix 1: Nomor surat halaman 1 (hardcoded)
    if (strpos($text, '400.10.2.2/') !== false) {
        $newText = 'Nomor: ${NOMOR_SURAT}';
    }
    // Fix 2: Nama kepala desa halaman 1
    elseif (trim($text) === 'MARPUDIN ') {
        $newText = '${KEPALA_DESA} ';
    }
    // Fix 3: Tanggal halaman 1 (16 September 2025)
    elseif ($text === '16 September 2025') {
        $newText = '${TANGGAL_SEKARANG}';
    }
    // Fix 4: Nomor surat halaman 2 - bagian 1
    elseif (strpos($text, 'Nomor: 474.1') !== false) {
        $newText = '                                            Nomor: ${NOMOR_SURAT} ';
    }
    // Fix 5: Nomor surat halaman 2 - bagian 2 (sisa "V / 2016")
    elseif ($text === 'V / 2016') {
        $newText = ''; // remove stray fragment
    }
    // Fix 6: Nama kepala desa halaman 2
    elseif (trim($text) === 'NANANG SUARNA') {
        $newText = '${KEPALA_DESA}';
    }
    // Fix 7: No KKS hardcoded
    elseif (strpos($text, 'PSKGf5d67005') !== false) {
        $newText = ': ${NO_KKS} ';
    }
    // Fix 8: Tanggal halaman 2 (23 Mei 2016)
    elseif (strpos($text, '23  Mei  2016') !== false) {
        $newText = '${TANGGAL_SEKARANG} ';
    }
    // Fix 9: Nomor surat halaman 3
    elseif (strpos($text, 'Nomor: 478.1/') !== false) {
        $newText = 'Nomor: ${NOMOR_SURAT} ';
    }
    // Fix 10: Tanggal halaman 3 (27 Maret 2020)
    elseif ($text === '27 Maret 2020') {
        $newText = '${TANGGAL_SEKARANG}';
    }

    if ($newText !== null) {
        $newTag = '<w:t' . $attrs . '>' . $newText . '</w:t>';
        $ops[] = ['pos' => $pos, 'orig' => $fullTag, 'new' => $newTag, 'text' => $text];
    }
}

// Now fix the Agama bug: find Agama: ${PEKERJAAN} and fix to ${AGAMA}
// This needs a broader XML search since it may span multiple runs
// Let's find the exact pattern in the XML
$agamaBugPattern = '/${PEKERJAAN}/';
// We need to check surrounding context; let's find all occurrences of ${PEKERJAAN}
preg_match_all('/\${PEKERJAAN}/', $xml, $pk, PREG_OFFSET_CAPTURE);
echo "Found " . count($pk[0]) . " occurrences of \${PEKERJAAN}\n";

// Find which one comes right after "Agama"
// Get context around each occurrence
foreach ($pk[0] as $occurrence) {
    $pkPos = $occurrence[1];
    $before = substr($xml, max(0, $pkPos - 200), 200);
    if (preg_match('/Agama[^{]*$/', $before)) {
        echo "  Found Agama bug at XML pos $pkPos\n";
        // Add fix op
        $ops[] = ['pos' => $pkPos, 'orig' => '${PEKERJAAN}', 'new' => '${AGAMA}', 'text' => 'AGAMA_BUG_FIX'];
    }
}

// Sort ops by position descending (apply from end to avoid position shifts)
usort($ops, fn($a, $b) => $b['pos'] - $a['pos']);

// Apply all replacements
$count = 0;
foreach ($ops as $op) {
    $old = $op['orig'];
    $new = $op['new'];
    
    // Find exact position and replace
    $actualPos = strpos($xml, $old, max(0, $op['pos'] - 10));
    if ($actualPos !== false) {
        $xml = substr_replace($xml, $new, $actualPos, strlen($old));
        echo "Fixed: '" . substr(strip_tags($op['orig']), 0, 50) . "' => '" . substr(strip_tags($op['new']), 0, 50) . "'\n";
        $count++;
    } else {
        echo "SKIP (not found): '" . substr(strip_tags($op['orig']), 0, 50) . "'\n";
    }
}

// Save
$zip->open($file);
$zip->addFromString('word/document.xml', $xml);
$zip->close();

echo "\nFixed $count items. Saved!\n";
