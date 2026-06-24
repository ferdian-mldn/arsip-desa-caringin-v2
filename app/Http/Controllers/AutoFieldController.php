<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataWarga;
use App\Models\TemplateSurat;
use App\Models\RiwayatCetak;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\TemplateProcessor;
use App\Utils\CustomTemplateProcessor;

class AutoFieldController extends Controller
{
    /**
     * Halaman utama Auto Field — form input NIK + pilih template
     */
    public function index()
    {
        $templates = TemplateSurat::where('status_aktif', true)->get();
        return view('autofield.index', compact('templates'));
    }

    /**
     * AJAX: Cari data warga berdasarkan NIK
     */
    public function cariWarga(Request $request)
    {
        $request->validate(['nik' => 'required|string|min:3']);

        $nik = $request->nik;

        // Cari exact match dulu
        $warga = DataWarga::where('nik', $nik)->first();

        if ($warga) {
            return response()->json([
                'status' => 'success',
                'data' => [
                    'id' => $warga->id,
                    'nik' => $warga->nik,
                    'no_kk' => $warga->no_kk,
                    'nama_lengkap' => $warga->nama_lengkap,
                    'jenis_kelamin' => $warga->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan',
                    'tempat_lahir' => $warga->tempat_lahir,
                    'tanggal_lahir' => $warga->tanggal_lahir ? $warga->tanggal_lahir->format('d-m-Y') : '-',
                    'agama' => DataWarga::namaAgama($warga->agama),
                    'status_perkawinan' => $warga->status_perkawinan,
                    'pekerjaan' => $warga->pekerjaan,
                    'pendidikan_terakhir' => $warga->pendidikan_terakhir,
                    'alamat' => $warga->alamat,
                    'rt' => $warga->rt,
                    'rw' => $warga->rw,
                    'kelurahan' => $warga->kelurahan,
                    'kecamatan' => $warga->kecamatan,
                    'kabupaten' => $warga->kabupaten,
                    'provinsi' => $warga->provinsi,
                    'nama_ibu' => $warga->nama_ibu,
                    'nama_ayah' => $warga->nama_ayah,
                    'alamat_lengkap' => $warga->alamat . ' RT ' . $warga->rt . '/RW ' . $warga->rw . ', Desa ' . $warga->kelurahan . ', Kec. ' . $warga->kecamatan . ', Kab. ' . $warga->kabupaten,
                ],
            ]);
        }

        // Jika tidak exact, cari by nama (suggestion)
        $suggestions = DataWarga::where('nik', 'LIKE', $nik . '%')
            ->orWhere('nama_lengkap', 'LIKE', '%' . $nik . '%')
            ->limit(5)
            ->get(['id', 'nik', 'nama_lengkap', 'alamat']);

        if ($suggestions->isNotEmpty()) {
            return response()->json([
                'status' => 'suggestions',
                'data' => $suggestions,
                'message' => 'NIK tidak ditemukan, berikut saran yang mirip:'
            ]);
        }

        return response()->json([
            'status' => 'not_found',
            'message' => 'Data warga dengan NIK tersebut tidak ditemukan.'
        ]);
    }

    /**
     * Generate dokumen Word dari template + data warga
     */
    public function generate(Request $request)
    {
        $request->validate([
            'id_warga' => 'required|exists:data_warga,id',
            'id_template' => 'required|exists:template_surat,id',
            'nomor_surat' => 'nullable|string|max:100',
        ]);

        $warga = DataWarga::findOrFail($request->id_warga);
        $template = TemplateSurat::findOrFail($request->id_template);

        // Cek file template ada
        $templatePath = storage_path('app/' . $template->lokasi_file);
        if (!file_exists($templatePath)) {
            return back()->withErrors(['File template tidak ditemukan di server.']);
        }

        // Proses generate dokumen menggunakan PHPWord TemplateProcessor
        $processor = new CustomTemplateProcessor($templatePath);

        // Mapping placeholder ke data warga
        $tanggalLahir = $warga->tanggal_lahir ? $warga->tanggal_lahir->format('d-m-Y') : '-';
        $ttl = $warga->tempat_lahir . ', ' . ($warga->tanggal_lahir ? $warga->tanggal_lahir->translatedFormat('d F Y') : '-');

        $replacements = [
            'NAMA_LENGKAP' => $warga->nama_lengkap,
            'NAMA' => $warga->nama_lengkap,
            'NIK' => $warga->nik,
            'NO_KK' => $warga->no_kk ?? '-',
            'JENIS_KELAMIN' => $warga->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan',
            'JK' => $warga->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan',
            'TEMPAT_LAHIR' => $warga->tempat_lahir ?? '-',
            'TANGGAL_LAHIR' => $tanggalLahir,
            'TTL' => $ttl,
            'AGAMA' => DataWarga::namaAgama($warga->agama),
            'STATUS_PERKAWINAN' => $warga->status_perkawinan ?? '-',
            'STATUS' => $warga->status_perkawinan ?? '-',
            'PEKERJAAN' => $warga->pekerjaan ?? '-',
            'PENDIDIKAN' => $warga->pendidikan_terakhir ?? '-',
            'ALAMAT' => $warga->alamat ?? '-',
            'RT' => $warga->rt ?? '-',
            'RW' => $warga->rw ?? '-',
            'KELURAHAN' => $warga->kelurahan ?? 'CARINGIN',
            'DESA' => $warga->kelurahan ?? 'CARINGIN',
            'KECAMATAN' => $warga->kecamatan ?? 'GEGERBITUNG',
            'KABUPATEN' => $warga->kabupaten ?? 'SUKABUMI',
            'PROVINSI' => $warga->provinsi ?? 'JAWA BARAT',
            'NAMA_IBU' => $warga->nama_ibu ?? '-',
            'NAMA_AYAH' => $warga->nama_ayah ?? '-',
            'ALAMAT_LENGKAP' => ($warga->alamat ?? '') . ' RT ' . ($warga->rt ?? '-') . '/RW ' . ($warga->rw ?? '-') . ', Desa ' . ($warga->kelurahan ?? 'CARINGIN'),
            'NOMOR_SURAT' => $request->nomor_surat ?? '......',
            'TANGGAL_SEKARANG' => now()->translatedFormat('d F Y'),
            'BULAN_ROMAWI' => $this->bulanRomawi(now()->month),
            'TAHUN' => now()->year,
            'KEWARGANEGARAAN' => 'Indonesia',
            'GOLONGAN_DARAH' => $warga->golongan_darah ?? '-',
            'KEPALA_DESA'       => 'MARPUDIN',
            'SEKRETARIS_DESA'   => 'EMAN HERMANSYAH, SE',
            'NO_KKS'            => '-',
            // Ketua RT/RW - diisi manual oleh pegawai desa
            'KETUA_RT'          => '..............................',
            'KETUA_RW'          => '..............................',
            'NO_RT'             => $warga->rt ?? '...',
            'NO_RW'             => $warga->rw ?? '...',
            // Data lain yang diisi manual
            'ASAL_SEKOLAH'      => '......................................................................',
            'JENIS_USAHA'       => '......................................................................',
            'PENGALAMAN_USAHA'  => '......',
            'LOKASI_USAHA'      => ($warga->alamat ?? '') . ' RT ' . ($warga->rt ?? '-') . ' RW ' . ($warga->rw ?? '-') . ' Desa ' . ($warga->kelurahan ?? 'CARINGIN'),
            'ALAMAT_LENGKAP'    => ($warga->alamat ?? '') . ' RT ' . ($warga->rt ?? '-') . ' RW ' . ($warga->rw ?? '-') . ' Desa ' . ($warga->kelurahan ?? 'CARINGIN') . ' Kecamatan ' . ($warga->kecamatan ?? 'GEGERBITUNG') . ' Kabupaten ' . ($warga->kabupaten ?? 'SUKABUMI'),
        ];

        // ----------------------------------------------------------------
        // Auto-detect data orang tua dari anggota keluarga yang sama (no_kk)
        // Prioritas: KEPALA KELUARGA → ISTRI → fallback titik-titik
        // ----------------------------------------------------------------
        $ortu = null;
        if ($warga->no_kk) {
            // Cari kepala keluarga dalam KK yang sama (bukan diri sendiri)
            $ortu = DataWarga::where('no_kk', $warga->no_kk)
                ->where('id', '!=', $warga->id)
                ->whereIn('shdk', ['KEPALA KELUARGA', 'ISTRI'])
                ->orderByRaw("FIELD(shdk, 'KEPALA KELUARGA', 'ISTRI')")
                ->first();
        }

        $dots64 = '......................................................................';
        $dots32 = '................................';
        $dots20 = '....................';

        if ($ortu) {
            $ttlOrtu = $ortu->tempat_lahir . ', ' . ($ortu->tanggal_lahir ? $ortu->tanggal_lahir->translatedFormat('d F Y') : '-');
            $alamatOrtu = ($ortu->alamat ?? '') . ' RT ' . ($ortu->rt ?? '-') . ' RW ' . ($ortu->rw ?? '-') . ' Desa ' . ($ortu->kelurahan ?? 'CARINGIN');
            $replacements['NAMA_ORTU']          = $ortu->nama_lengkap;
            $replacements['NIK_ORTU']           = $ortu->nik;
            $replacements['NO_KK_ORTU']         = $ortu->no_kk ?? $dots32;
            $replacements['TTL_ORTU']           = $ttlOrtu;
            $replacements['JENIS_KELAMIN_ORTU'] = $ortu->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan';
            $replacements['ALAMAT_ORTU']        = $alamatOrtu;
            $replacements['PEKERJAAN_ORTU']     = $ortu->pekerjaan ?? $dots64;
        } else {
            // Fallback: titik-titik untuk dilengkapi manual
            $replacements['NAMA_ORTU']          = $dots64;
            $replacements['NIK_ORTU']           = $dots32;
            $replacements['NO_KK_ORTU']         = $dots32;
            $replacements['TTL_ORTU']           = $dots64;
            $replacements['JENIS_KELAMIN_ORTU'] = $dots20;
            $replacements['ALAMAT_ORTU']        = $dots64;
            $replacements['PEKERJAAN_ORTU']     = $dots64;
        }
        // ----------------------------------------------------------------

        // Replace semua placeholder biasa
        foreach ($replacements as $key => $value) {
            try {
                $processor->setValue($key, $value ?? '-');
            } catch (\Exception $e) {
                // skip jika placeholder tidak ada di template ini
            }
        }

        // ----------------------------------------------------------------
        // Penggantian per-karakter untuk kotak-kotak formulir KTP
        // Menggunakan str_replace pada XML agar 100% berhasil tanpa PHPWord
        // ----------------------------------------------------------------
        $xml = $processor->getMainPartXml();

        // 1. Nama Lengkap — kotak "1. Nama Lengkap" (maks 50 kotak)
        $namaChars = str_split($warga->nama_lengkap ?? '');
        for ($i = 0; $i < 50; $i++) {
            $char = $namaChars[$i] ?? '';
            $xml = str_replace('${NAMA_' . ($i + 1) . '}', htmlspecialchars($char, ENT_XML1, 'UTF-8'), $xml);
        }

        // 2. No KK — kotak "2. No. KK" (16 kotak)
        $kkChars = str_split($warga->no_kk ?? '');
        for ($i = 0; $i < 16; $i++) {
            $char = $kkChars[$i] ?? '';
            $xml = str_replace('${KK_' . ($i + 1) . '}', htmlspecialchars($char, ENT_XML1, 'UTF-8'), $xml);
        }

        // 3. NIK — kotak "3. N I K" (16 kotak)
        $nikChars = str_split($warga->nik ?? '');
        for ($i = 0; $i < 16; $i++) {
            $char = $nikChars[$i] ?? '';
            $xml = str_replace('${NIK_' . ($i + 1) . '}', htmlspecialchars($char, ENT_XML1, 'UTF-8'), $xml);
        }

        // 4. RT — 3 kotak digit (zero-padded ke 3 angka)
        $rtPadded = str_pad($warga->rt ?? '0', 3, '0', STR_PAD_LEFT);
        for ($i = 0; $i < 3; $i++) {
            $xml = str_replace('${RT_' . ($i + 1) . '}', $rtPadded[$i], $xml);
        }

        // 5. RW — 3 kotak digit (zero-padded ke 3 angka)
        $rwPadded = str_pad($warga->rw ?? '0', 3, '0', STR_PAD_LEFT);
        for ($i = 0; $i < 3; $i++) {
            $xml = str_replace('${RW_' . ($i + 1) . '}', $rwPadded[$i], $xml);
        }

        // 6. NO_KK per digit (surat pindah — 16 kotak)
        $kkDigits = str_split(str_pad($warga->no_kk ?? '', 16, ' '));
        for ($i = 0; $i < 16; $i++) {
            $xml = str_replace('${NO_KK_' . ($i + 1) . '}', htmlspecialchars($kkDigits[$i] ?? '', ENT_XML1, 'UTF-8'), $xml);
        }

        // 7. Tanggal pindah per digit ddmmyyyy (surat pindah)
        $tglPindah = str_pad(now()->format('dmY'), 8, '0', STR_PAD_LEFT);
        for ($i = 0; $i < 8; $i++) {
            $xml = str_replace('${TGL_PINDAH_' . ($i + 1) . '}', $tglPindah[$i], $xml);
        }

        // 8. Tanggal datang — kosong (diisi saat tiba di tujuan)
        for ($i = 0; $i < 8; $i++) {
            $xml = str_replace('${TGL_DATANG_' . ($i + 1) . '}', ' ', $xml);
        }

        // 9. RT/RW tujuan — kosong (diisi manual)
        for ($i = 0; $i < 3; $i++) {
            $xml = str_replace('${RT_TUJUAN_' . ($i + 1) . '}', ' ', $xml);
            $xml = str_replace('${RW_TUJUAN_' . ($i + 1) . '}', ' ', $xml);
        }

        // 10. Kode pos tujuan — kosong (diisi manual)
        for ($i = 0; $i < 5; $i++) {
            $xml = str_replace('${KODEPOS_TUJUAN_' . ($i + 1) . '}', ' ', $xml);
        }

        // 11. SHDK warga
        $xml = str_replace('${SHDK}', htmlspecialchars($warga->shdk ?? '-', ENT_XML1, 'UTF-8'), $xml);

        // 12. Variabel tujuan pindah — diisi manual
        foreach (['ALAMAT_TUJUAN', 'DESA_TUJUAN', 'KECAMATAN_TUJUAN', 'KABUPATEN_TUJUAN', 'PROVINSI_TUJUAN'] as $key) {
            $xml = str_replace('${' . $key . '}', '..............................', $xml);
        }

        $processor->setMainPartXml($xml);
        // ----------------------------------------------------------------

        // Generate nama file
        $namaFile = str_replace(' ', '_', $template->kode_template) . '_' . str_replace(' ', '_', $warga->nama_lengkap) . '_' . date('Ymd_His') . '.docx';

        // Simpan ke temp
        $tempPath = storage_path('app/public/' . $namaFile);
        $processor->saveAs($tempPath);

        // Simpan riwayat cetak
        RiwayatCetak::create([
            'id_user' => Auth::id(),
            'id_template' => $template->id,
            'id_warga' => $warga->id,
            'nomor_surat' => $request->nomor_surat,
            'data_snapshot' => $replacements,
        ]);

        // Download & hapus file temp
        return response()->download($tempPath, $namaFile)->deleteFileAfterSend(true);
    }

    /**
     * Halaman riwayat cetak dokumen
     */
    public function riwayat()
    {
        $riwayat = RiwayatCetak::with(['user', 'template', 'warga'])
            ->latest()
            ->paginate(15);

        return view('autofield.riwayat', compact('riwayat'));
    }

    /**
     * Helper: Bulan ke Romawi
     */
    private function bulanRomawi($bulan)
    {
        $romawi = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV',
            5 => 'V', 6 => 'VI', 7 => 'VII', 8 => 'VIII',
            9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];
        return $romawi[$bulan] ?? '';
    }
}
