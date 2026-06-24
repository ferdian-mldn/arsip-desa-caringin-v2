<?php
$file = 'storage/app/templates/surat_pindah_kab.docx';
$zip = new ZipArchive;
$zip->open($file);
$xml = $zip->getFromName('word/document.xml');
$zip->close();

preg_match_all('/<w:t([^>]*)>([^<]+)<\/w:t>/', $xml, $matches, PREG_OFFSET_CAPTURE);

// ── Peta penggantian ──
$replacements = [
    // NO KK per digit [16..34] → ${NO_KK} per kotak
    // No KK punya 16 digit, per kotak 1 huruf. Ganti [16] dengan ${NO_KK_1} dst.
    // Tapi lebih simpel: ganti semuanya, [16] jadi ${NO_KK} dan sisanya kosong
    16 => '${NO_KK_1}',
    17 => '${NO_KK_2}',
    18 => '${NO_KK_3}',
    19 => '${NO_KK_4}',
    20 => '${NO_KK_5}',
    21 => '${NO_KK_6}',
    22 => '${NO_KK_7}',
    23 => '${NO_KK_8}',
    24 => '${NO_KK_9}',
    25 => '${NO_KK_10}',
    26 => '${NO_KK_11}',
    27 => '${NO_KK_12}',
    28 => '${NO_KK_13}',
    29 => '${NO_KK_14}',
    30 => '${NO_KK_15}',
    31 => '${NO_KK_16}',
    32 => ' ',  // extra cells jika ada
    33 => ' ',
    34 => ' ',

    // Alamat asal [40..68]
    40 => '${ALAMAT}',
    41 => '', 42 => '',
    43 => '${RT_1}', 44 => '${RT_2}', 45 => '${RT_3}',
    46 => '',
    47 => '${RW_1}', 48 => '${RW_2}', 49 => '${RW_3}',
    52 => '${KELURAHAN}',
    56 => '${KABUPATEN}',
    59 => '${KECAMATAN}',
    62 => '${PROVINSI}',
    64 => '4', 65 => '3', 66 => '1', 67 => '9', 68 => '7', // kode pos tetap

    // Alamat tujuan [93..121] → variabel tujuan (diisi manual)
    93 => '${ALAMAT_TUJUAN}',
    94 => '', 95 => '',
    96 => '${RT_TUJUAN_1}', 97 => '${RT_TUJUAN_2}', 98 => '${RT_TUJUAN_3}',
    99 => '',
    100 => '${RW_TUJUAN_1}', 101 => '${RW_TUJUAN_2}', 102 => '${RW_TUJUAN_3}',
    105 => '${DESA_TUJUAN}',
    109 => '${KABUPATEN_TUJUAN}',
    112 => '${KECAMATAN_TUJUAN}',
    115 => '${PROVINSI_TUJUAN}',
    117 => '${KODEPOS_TUJUAN_1}',
    118 => '${KODEPOS_TUJUAN_2}',
    119 => '${KODEPOS_TUJUAN_3}',
    120 => '${KODEPOS_TUJUAN_4}',
    121 => '${KODEPOS_TUJUAN_5}',

    // Rencana tgl pindah per kotak [171..178] → ${TANGGAL_PINDAH} per digit
    171 => '${TGL_PINDAH_1}', 172 => '${TGL_PINDAH_2}',
    173 => '${TGL_PINDAH_3}', 174 => '${TGL_PINDAH_4}',
    175 => '${TGL_PINDAH_5}', 176 => '${TGL_PINDAH_6}',
    177 => '${TGL_PINDAH_7}', 178 => '${TGL_PINDAH_8}',

    // NIK warga dalam tabel [186..201] per digit
    186 => '${NIK_1}',  187 => '${NIK_2}',  188 => '${NIK_3}',  189 => '${NIK_4}',
    190 => '${NIK_5}',  191 => '${NIK_6}',  192 => '${NIK_7}',  193 => '${NIK_8}',
    194 => '${NIK_9}',  195 => '${NIK_10}', 196 => '${NIK_11}', 197 => '${NIK_12}',
    198 => '${NIK_13}', 199 => '${NIK_14}', 200 => '${NIK_15}', 201 => '${NIK_16}',

    // SHDK warga [203..207] → ${SHDK}
    203 => '${SHDK}',
    204 => '', 205 => '', 206 => '', 207 => '',

    // Tahun di tanda tangan bawah [214][215] & [221][222]
    213 => 'No ………………… tgl…………………..${TAHUN}',
    214 => '', 215 => '',
    220 => 'No ………………… tgl…………………..${TAHUN}',
    221 => '', 222 => '',

    // Nomor surat kepala desa [231..237]
    231 => '${NOMOR_SURAT}',
    232 => '', 233 => '', 234 => '', 235 => '', 236 => '', 237 => '${TANGGAL_SEKARANG}',

    // Kepala Desa [238]
    238 => '${KEPALA_DESA}',

    // Tanggal kedatangan tujuan [257..264] → kosong (diisi saat diterima)
    257 => '${TGL_DATANG_1}', 258 => '${TGL_DATANG_2}',
    259 => '${TGL_DATANG_3}', 260 => '${TGL_DATANG_4}',
    261 => '${TGL_DATANG_5}', 262 => '${TGL_DATANG_6}',
    263 => '${TGL_DATANG_7}', 264 => '${TGL_DATANG_8}',
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
        echo "  SKIP idx={$op['idx']}: '" . substr(strip_tags($op['orig']), 0, 30) . "'\n";
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
foreach (['3202401604080005', '3202401702970002', 'MARPUDIN', 'KP.CARINGIN', 'JL.TIPAR', '400.10.2.2', '26-09-2025', '12032008'] as $c) {
    echo "  '$c': " . (strpos($xml, $c) !== false ? "STILL PRESENT!" : "cleaned") . "\n";
}
