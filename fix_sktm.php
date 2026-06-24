<?php
$file = 'storage/app/templates/sktm_sekolah_new.docx';
$zip = new ZipArchive;
$zip->open($file);
$xml = $zip->getFromName('word/document.xml');
$zip->close();

// Get all text nodes with POSITIONS (critical for correct replacement)
preg_match_all('/<w:t([^>]*)>([^<]+)<\/w:t>/', $xml, $matches, PREG_OFFSET_CAPTURE);

// Map of index => replacement text (null = keep as is)
// Based on dump analysis:
// HALAMAN 1 (surat anak kandung):
//   [5][6][7][8][9][10][11] = Nomor  -> ${NOMOR_SURAT}
//   [27] 'Laki- Laki'       -> ${JENIS_KELAMIN}  (siswa)
//   [31..42] alamat siswa   -> ${ALAMAT_LENGKAP}
//   [45] 'SMP NEGERI CIREUNGHAS' -> ${ASAL_SEKOLAH}
//   [51] 'ARIP KURNIA '     -> ${NAMA_ORTU}
//   [57..59] NIK ortu       -> ${NIK_ORTU}
//   [61..62] TTL ortu       -> ${TTL_ORTU}
//   [65] 'Laki- Laki '      -> ${JENIS_KELAMIN_ORTU}
//   [70..75] alamat ortu    -> ${ALAMAT_ORTU}
//   [83][84] tanggal        -> ${TANGGAL_SEKARANG}
//   [86] M A R P U D I N   -> ${KEPALA_DESA}

// HALAMAN 2 (orang tua kandung):
//   [95..99] Nomor          -> ${NOMOR_SURAT}
//   [103] 'ASEP NASRUDIN'   -> ${NAMA_ORTU}
//   [105..106] NO KK ortu   -> ${NO_KK_ORTU}
//   [108..109] NIK ortu     -> ${NIK_ORTU}
//   [111..112] TTL ortu     -> ${TTL_ORTU}
//   [115] 'Laki- Laki'      -> ${JENIS_KELAMIN_ORTU}
//   [119..128] alamat ortu  -> ${ALAMAT_ORTU}
//   [141] NO KK siswa hardcoded -> ${NO_KK}
//   [150] 'Perempuan'       -> ${JENIS_KELAMIN}
//   [155..158] alamat siswa -> ${ALAMAT_LENGKAP}
//   [161] 'SMA 3 SUKABUMI'  -> ${ASAL_SEKOLAH}
//   [168][169] tanggal      -> ${TANGGAL_SEKARANG}
//   [171] M A R P U D I N  -> ${KEPALA_DESA}

// HALAMAN 3 (orang tua/wali):
//   [179] Nomor             -> ${NOMOR_SURAT}
//   [183] 'ASEP SUMARDI'    -> ${NAMA_ORTU}
//   [186] NO KK ortu        -> ${NO_KK_ORTU}
//   [189] NIK ortu          -> ${NIK_ORTU}
//   [191..192] TTL ortu     -> ${TTL_ORTU}
//   [195] 'Laki- Laki'      -> ${JENIS_KELAMIN_ORTU}
//   [197] Pekerjaan ortu    -> ${PEKERJAAN_ORTU}
//   [200..203] alamat ortu  -> ${ALAMAT_ORTU}
//   [220] 'Laki-laki'       -> ${JENIS_KELAMIN} (siswa)
//   [223] 'MA Ash-Sholahiyah' -> ${ASAL_SEKOLAH}
//   [230] Caringin, 08 Oktober 2019 -> ${TANGGAL_SEKARANG}
//   [231] Pj. KEPALA DESA  -> KEPALA DESA CARINGIN (clean)
//   [232..233] AJAT SUDRAJAT -> ${KEPALA_DESA}
//   [234] Nip...            -> (remove/blank)
//   [240] 13 Juli 2017      -> ${TANGGAL_SEKARANG}
//   [243] EMAN HERMANSYAH   -> ${SEKRETARIS_DESA}

$replacements = [
    // HALAMAN 1 nomor surat (fragmented across multiple nodes)
    5  => '${NOMOR_SURAT}',
    6  => '',  // was '2' (part of number)
    7  => '',  // was ' /      / '
    8  => '',  // was 'V'
    9  => '',  // was ' '
    10 => '',  // was '/ 202'
    11 => '',  // was '6'
    
    // Halaman 1 siswa
    27 => '${JENIS_KELAMIN}',        // Jenis kelamin siswa
    31 => ': ${ALAMAT_LENGKAP}',     // Alamat siswa (replace ': Kp.')
    32 => '',
    33 => '',
    34 => '',
    35 => '',
    36 => '',
    37 => '',
    38 => '',
    39 => '',
    40 => '',
    41 => '',
    42 => '',
    45 => '${ASAL_SEKOLAH}',         // Asal sekolah
    
    // Halaman 1 orang tua
    51 => '${NAMA_ORTU}',            // Nama orang tua
    55 => '${NO_KK_ORTU}',           // NO KK ortu (already has ${NO_KK})
    57 => ':  ',                      // NO NIK: (keep label)
    58 => '${NIK_ORTU}',             // NIK ortu (replace fragmented)
    59 => '',
    61 => ':  ',                      // TTL label
    62 => '${TTL_ORTU}',             // TTL ortu
    65 => '${JENIS_KELAMIN_ORTU}',   // JK ortu
    70 => '${ALAMAT_ORTU}',          // Alamat ortu
    71 => '', 72 => '', 73 => '', 74 => '', 75 => '',
    
    // Halaman 1 tanggal
    83 => '  Caringin, ${TANGGAL_SEKARANG}',
    84 => '',
    86 => '${KEPALA_DESA}',
    
    // HALAMAN 2 nomor surat (fragmented)
    95 => '${NOMOR_SURAT}',
    96 => '',
    97 => '',
    98 => '',
    99 => '',
    
    // Halaman 2 orang tua (top section)
    103 => '${NAMA_ORTU}',
    105 => ':  ',
    106 => '${NO_KK_ORTU}',
    108 => ':  ',
    109 => '${NIK_ORTU}',
    111 => ':  ',
    112 => '${TTL_ORTU}',
    115 => '${JENIS_KELAMIN_ORTU}',
    119 => ':  ',
    120 => '${ALAMAT_ORTU}',
    121 => '', 122 => '', 123 => '', 124 => '', 125 => '', 126 => '', 127 => '', 128 => '',
    
    // Halaman 2 siswa
    141 => '${NO_KK}',               // NO KK siswa yang hardcoded
    150 => '${JENIS_KELAMIN}',        // JK siswa
    155 => '${ALAMAT_LENGKAP}',       // Alamat siswa
    156 => '', 157 => '', 158 => '',
    161 => ': ${ASAL_SEKOLAH}  ',     // Asal sekolah
    
    // Halaman 2 tanggal & kepala desa
    168 => '${TANGGAL_SEKARANG}',
    169 => '',
    171 => '${KEPALA_DESA}',
    
    // HALAMAN 3 nomor surat
    179 => 'Nomor : ${NOMOR_SURAT}',
    
    // Halaman 3 orang tua
    183 => '${NAMA_ORTU}',
    186 => '${NO_KK_ORTU}',
    189 => '${NIK_ORTU}',
    191 => ':  ',
    192 => '${TTL_ORTU}',
    195 => ':  ${JENIS_KELAMIN_ORTU} ',
    197 => ':  ${PEKERJAAN_ORTU}       ',
    200 => ':  ${ALAMAT_ORTU}',
    201 => '', 202 => '', 203 => '',
    
    // Halaman 3 siswa
    220 => ':  ${JENIS_KELAMIN} ',
    223 => '${ASAL_SEKOLAH}',
    
    // Halaman 3 tanggal
    230 => '  Caringin, ${TANGGAL_SEKARANG}',
    
    // Halaman 3 kepala desa (dulu ada Pj. & AJAT SUDRAJAT)
    231 => 'KEPALA DESA CARINGIN',
    232 => '${KEPALA_DESA}',
    233 => '',
    234 => '',  // remove NIP
    
    // Halaman 3 tanggal bawah
    240 => '${TANGGAL_SEKARANG}',
    
    // Sekretaris desa
    243 => '${SEKRETARIS_DESA}          ',
];

// Apply replacements by position (reverse order to preserve offsets)
$ops = [];
foreach ($replacements as $idx => $newText) {
    if (!isset($matches[0][$idx])) continue;
    $pos     = $matches[0][$idx][1];
    $fullTag = $matches[0][$idx][0];
    $attrs   = $matches[1][$idx][0];
    
    if ($newText === '') {
        $newTag = '<w:t' . $attrs . '> </w:t>'; // empty but valid XML
    } else {
        $newTag = '<w:t' . $attrs . '>' . $newText . '</w:t>';
    }
    
    $ops[] = ['pos' => $pos, 'orig' => $fullTag, 'new' => $newTag, 'idx' => $idx];
}

// Sort descending by position to avoid shift issues
usort($ops, fn($a, $b) => $b['pos'] - $a['pos']);

$count = 0;
foreach ($ops as $op) {
    $searchPos = $op['pos'];
    // Find actual position in current xml (may have shifted slightly from previous ops since we go reverse)
    $actualPos = strpos($xml, $op['orig'], max(0, $searchPos - 5));
    if ($actualPos !== false) {
        $xml = substr_replace($xml, $op['new'], $actualPos, strlen($op['orig']));
        $count++;
    } else {
        // Try from beginning as fallback
        $actualPos = strpos($xml, $op['orig']);
        if ($actualPos !== false) {
            $xml = substr_replace($xml, $op['new'], $actualPos, strlen($op['orig']));
            $count++;
            echo "  [fallback] idx={$op['idx']}\n";
        } else {
            echo "  SKIP idx={$op['idx']}: not found\n";
        }
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

// Check for remaining hardcoded issues
echo "\nRemaining hardcoded checks:\n";
foreach (['ARIP KURNIA', 'ASEP NASRUDIN', 'ASEP SUMARDI', 'AJAT SUDRAJAT', '3202401904790001', '3202400808070909', 'M A R P U D I N', 'MARPUDIN', '11 Mei', '30 Juli', '08 Oktober', '13 Juli'] as $check) {
    echo "  '$check': " . (strpos($xml, $check) !== false ? "STILL PRESENT!" : "cleaned") . "\n";
}
