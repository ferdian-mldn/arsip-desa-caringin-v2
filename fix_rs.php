<?php
$file = 'storage/app/templates/sktm.rumah_sakit.docx';
$zip = new ZipArchive;
$zip->open($file);
$xml = $zip->getFromName('word/document.xml');
$zip->close();

preg_match_all('/<w:t([^>]*)>([^<]+)<\/w:t>/', $xml, $matches, PREG_OFFSET_CAPTURE);

// Map of text node index => replacement
// HALAMAN 1: Surat Keterangan (Ketua DKM - ini bisa direpurpose untuk warga umum)
// HALAMAN 2: Surat Keterangan Miskin RS (yang punya ${NAMA_LENGKAP} etc.)

$replacements = [
    // ── HALAMAN 1 ──
    // Nomor surat (fragmented across many nodes [5]..[18])
    5  => '${NOMOR_SURAT}',
    6  => '', 7 => '', 8 => '', 9 => '', 10 => '', 11 => '',
    12 => '', 13 => '', 14 => '', 15 => '', 16 => '', 17 => '', 18 => '',

    // Nama warga [26]
    26 => '${NAMA_LENGKAP} ',

    // NIK [29]
    29 => '${NIK}',

    // TTL [33][34]
    33 => '',
    34 => '${TTL}',

    // Jabatan/Pekerjaan [37]
    37 => '${PEKERJAAN}',

    // Alamat [41..62] -> ganti semua ke ALAMAT_LENGKAP, hapus sisanya
    41 => '${ALAMAT_LENGKAP}',
    42 => '', 43 => '', 44 => '', 45 => '', 46 => '', 47 => '',
    48 => '', 49 => '', 50 => '', 51 => '', 52 => '', 53 => '',
    54 => '', 55 => '', 56 => '', 57 => '', 58 => '', 59 => '',
    60 => '', 61 => '', 62 => '',

    // Isi surat [63..72] -> biarkan karena itu kalimat generik yang masih relevan
    // (akan tetap apa adanya)

    // Tanggal [84][85][86][87][88]
    84 => '${TANGGAL_SEKARANG}',
    85 => '', 86 => '', 87 => '', 88 => '',

    // Sekretaris desa [97]
    97 => '${SEKRETARIS_DESA}  ',

    // NIP lama [105] -> hapus
    104 => '',
    105 => '',

    // ── HALAMAN 2 ──
    // Nomor surat [116][117][118][119]
    116 => 'No : ${NOMOR_SURAT}',
    117 => '', 118 => '', 119 => '',

    // Info RT/RW header halaman 2 [108..113] → biarkan (label statis)

    // Pekerjaan [141]
    141 => '${PEKERJAAN} ',

    // Alamat [144..159] -> ALAMAT_LENGKAP
    144 => '${ALAMAT_LENGKAP}',
    145 => '', 146 => '', 147 => '', 148 => '', 149 => '',
    150 => '', 151 => '', 152 => '', 153 => '', 154 => '',
    155 => '', 156 => '', 157 => '', 158 => '', 159 => '',

    // Tanggal [167]
    167 => '${TANGGAL_SEKARANG}',

    // Ketua RW [170]
    170 => '${KETUA_RW}',

    // Nomor RW di header [169]
    169 => '${NO_RW}',

    // Ketua RT [176]
    176 => '${KETUA_RT}',

    // Nomor RT di header [175]
    175 => '${NO_RT}',
];

// Apply by position (reverse order)
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
    if ($actualPos !== false) {
        $xml = substr_replace($xml, $op['new'], $actualPos, strlen($op['orig']));
        $count++;
    } else {
        $actualPos = strpos($xml, $op['orig']);
        if ($actualPos !== false) {
            $xml = substr_replace($xml, $op['new'], $actualPos, strlen($op['orig']));
            $count++;
        } else {
            echo "  SKIP idx={$op['idx']}: '" . strip_tags($op['orig']) . "'\n";
        }
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
foreach (['ACEP SUGANDA', '3202402301720001', '21-08-1968', 'Tegalsereh', '15 Oktober', 'EMAN HERMANSYAH', '13 Juni', 'E.KOSASIH', 'SOLIHIN', '2005/', '445.1'] as $c) {
    echo "  '$c': " . (strpos($xml, $c) !== false ? "STILL PRESENT!" : "cleaned") . "\n";
}
