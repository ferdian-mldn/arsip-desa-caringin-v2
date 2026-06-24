<?php
$file = 'storage/app/templates/sktm.docx';
$zip = new ZipArchive;
$zip->open($file);
$xml = $zip->getFromName('word/document.xml');
$zip->close();

preg_match_all('/<w:t([^>]*)>([^<]+)<\/w:t>/', $xml, $matches, PREG_OFFSET_CAPTURE);

$replacements = [
    // ── HALAMAN 1: SKTM PLN ──
    // Nomor surat [10]
    10 => '${NOMOR_SURAT}',

    // Nama kepala desa [14]
    14 => '${KEPALA_DESA}',

    // Tanggal [34]
    34 => '${TANGGAL_SEKARANG}',

    // Tanda tangan M A R P U D I N [38]
    38 => '${KEPALA_DESA}',

    // ── HALAMAN 2: Surat Keterangan Akte Kelahiran ──
    // Nomor surat [52][53][54]
    52 => 'Nomor: ${NOMOR_SURAT}',
    53 => '', 54 => '',

    // Nama kepala desa lama [58]
    58 => '${KEPALA_DESA}',

    // TTL [73]
    73 => ':  ${TTL}',

    // Jenis kelamin [75]
    75 => ':  ${JENIS_KELAMIN}  ',

    // Pekerjaan [78]
    78 => '${PEKERJAAN}',

    // Alamat [81]
    81 => ':  ${ALAMAT_LENGKAP}',

    // Tanggal [89][90]
    89 => '${TANGGAL_SEKARANG}',
    90 => '',

    // Nama kepala desa lama di tanda tangan [95]
    95 => '        ${KEPALA_DESA}   ',
];

// Apply reverse order
$ops = [];
foreach ($replacements as $idx => $newText) {
    if (!isset($matches[0][$idx])) continue;
    $pos     = $matches[0][$idx][1];
    $fullTag = $matches[0][$idx][0];
    $attrs   = $matches[1][$idx][0];
    $newTag  = $newText === '' ? '<w:t' . $attrs . '> </w:t>' : '<w:t' . $attrs . '>' . $newText . '</w:t>';
    $ops[]   = ['pos' => $pos, 'orig' => $fullTag, 'new' => $newTag, 'idx' => $idx];
}

usort($ops, fn($a, $b) => $b['pos'] - $a['pos']);

$count = 0;
foreach ($ops as $op) {
    $actualPos = strpos($xml, $op['orig'], max(0, $op['pos'] - 5));
    if ($actualPos === false) $actualPos = strpos($xml, $op['orig']);
    if ($actualPos !== false) {
        $xml = substr_replace($xml, $op['new'], $actualPos, strlen($op['orig']));
        $count++;
    } else {
        echo "  SKIP idx={$op['idx']}: '" . substr(strip_tags($op['orig']), 0, 40) . "'\n";
    }
}

// Save
$zip->open($file);
$zip->addFromString('word/document.xml', $xml);
$zip->close();

echo "Fixed $count nodes. Saved!\n\n";

// Verify
preg_match_all('/\${([^}]+)}/', $xml, $varMatches);
$vars = array_unique($varMatches[1]);
sort($vars);
echo "Variables in template:\n";
foreach ($vars as $v) { echo "  \${$v}\n"; }

// Hardcoded checks
echo "\nHardcoded checks:\n";
foreach (['MARPUDIN', 'NANANG SUARNA', 'M A R P U D I N', '400.10.2.2', '474.1', '14 Mei', '04 Januari', 'Sukabumi, 02', 'Laki- Laki', 'Belum Bekerja', 'Kp.Cigeblug'] as $c) {
    echo "  '$c': " . (strpos($xml, $c) !== false ? "STILL PRESENT!" : "cleaned") . "\n";
}
