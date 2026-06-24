<?php
$file = 'storage/app/templates/sku_new.docx';
$zip = new ZipArchive;
$zip->open($file);
$xml = $zip->getFromName('word/document.xml');
$zip->close();

preg_match_all('/<w:t([^>]*)>([^<]+)<\/w:t>/', $xml, $matches, PREG_OFFSET_CAPTURE);

$replacements = [
    // ── HALAMAN 1: SKU (Surat Keterangan Usaha) ──

    // Nomor surat [7..13]
    7  => '${NOMOR_SURAT}',
    8  => '', 9 => '', 10 => '', 11 => '', 12 => '', 13 => '',

    // Penandatangan [18] EMAN HERMANSYAH -> KEPALA_DESA
    18 => '${KEPALA_DESA}',

    // Jabatan [23][24] -> Kepala Desa Caringin
    23 => 'Kepala',
    24 => ' Desa Caringin',

    // Jenis Kelamin [41]
    41 => '${JENIS_KELAMIN} ',

    // Status Perkawinan [55]
    55 => '${STATUS_PERKAWINAN} ',

    // Agama [57]
    57 => ': ${AGAMA}',

    // Pekerjaan [60]
    60 => '${PEKERJAAN} ',

    // Alamat warga [64..85] -> ALAMAT_LENGKAP
    64 => '${ALAMAT_LENGKAP}',
    65 => '', 66 => '', 67 => '', 68 => '', 69 => '', 70 => '',
    71 => '', 72 => '', 73 => '', 74 => '', 75 => '', 76 => '',
    77 => '', 78 => '', 79 => '', 80 => '', 81 => '', 82 => '',
    83 => '', 84 => '', 85 => '',

    // Jenis Usaha [92..96] -> JENIS_USAHA
    92 => ' ',
    93 => '${JENIS_USAHA}',
    94 => '', 95 => '', 96 => '',

    // Pengalaman Usaha [100] -> PENGALAMAN_USAHA
    100 => '${PENGALAMAN_USAHA}',
    101 => '', 102 => '',

    // Lokasi usaha [105..114] -> LOKASI_USAHA
    105 => '${LOKASI_USAHA}',
    106 => '', 107 => '', 108 => '', 109 => '', 110 => '', 111 => '',
    112 => '', 113 => '', 114 => '',

    // Tanggal [119..121]
    119 => '',
    120 => '',
    121 => '${TANGGAL_SEKARANG}',

    // Sekretaris desa bawah [126]
    126 => '${KEPALA_DESA} ',

    // ── HALAMAN 2: Surat Keterangan (KKS) ──

    // Nomor surat [132][133]
    132 => '                                            Nomor: ${NOMOR_SURAT}',
    133 => '',

    // Nama penandatangan [137]
    137 => '${KEPALA_DESA}',

    // JK [151]
    151 => '${JENIS_KELAMIN} ',

    // Status [161][162]
    161 => '${STATUS_PERKAWINAN}',
    162 => ' ',

    // Agama [165]
    165 => '${AGAMA}',

    // Pekerjaan [168]
    168 => '${PEKERJAAN} ',

    // Alamat warga [171..178]
    171 => '${ALAMAT_LENGKAP}',
    172 => '', 173 => '', 174 => '', 175 => '', 176 => '', 177 => '', 178 => '',

    // No KKS [183]
    183 => ': ${NO_KKS} ',

    // Alamat di KKS section [188]
    188 => ': ${ALAMAT_LENGKAP} ',

    // Tanggal [193]
    193 => '${TANGGAL_SEKARANG} ',

    // ── HALAMAN 3: Surat Keterangan Domisili ──

    // Nomor surat [200..206]
    200 => 'Nomor: ${NOMOR_SURAT}',
    201 => '', 202 => '', 203 => '', 204 => '', 205 => '', 206 => '',

    // JK [220]
    220 => '${JENIS_KELAMIN}',

    // Status [227]
    227 => ': ${STATUS_PERKAWINAN} ',

    // Agama [229]
    229 => ': ${AGAMA}',

    // Pekerjaan [232][233]
    232 => '',
    233 => '${PEKERJAAN} ',

    // Alamat [236..248]
    236 => '${ALAMAT_LENGKAP}',
    237 => '', 238 => '', 239 => '', 240 => '', 241 => '', 242 => '',
    243 => '', 244 => '', 245 => '', 246 => '', 247 => '', 248 => '',

    // Tanggal [257][258]
    257 => '${TANGGAL_SEKARANG}',
    258 => '',

    // Sekretaris [262]
    262 => '${SEKRETARIS_DESA}  ',
];

// Apply by position descending
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
        echo "  SKIP idx={$op['idx']}: '" . strip_tags($op['orig']) . "'\n";
    }
}

// Save
$zip->open($file);
$zip->addFromString('word/document.xml', $xml);
$zip->close();

echo "Fixed $count nodes. Saved!\n\n";

// Verify variables
preg_match_all('/\${([^}]+)}/', $xml, $varMatches);
$vars = array_unique($varMatches[1]);
sort($vars);
echo "Variables in template:\n";
foreach ($vars as $v) { echo "  \${$v}\n"; }

// Hardcoded checks
echo "\nHardcoded checks:\n";
foreach (['EMAN HERMANSYAH', 'NANANG SUARNA', 'Laki- laki', 'Laki- Laki', 'Kawin ', 'Islam', 'Buruh harian lepas', 'Sopir', 'Kp. Caringin', 'Kp.Kawungluwuk', 'Kp. Cigobag', 'PSKGf5d67005', '13 Mei', '23  Mei', '14 Oktober', '474.1', '478.1', '100.2.3'] as $c) {
    echo "  '$c': " . (strpos($xml, $c) !== false ? "STILL PRESENT!" : "cleaned") . "\n";
}
