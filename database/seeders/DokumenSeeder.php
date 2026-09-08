<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Dokumen;
use App\Models\Kategori;
use App\Models\UnitKerja;
use App\Models\User;

class DokumenSeeder extends Seeder
{
    /**
     * Folder sumber dokumen (relatif dari root project)
     */
    private string $sourceDir;

    public function run(): void
    {
        $this->sourceDir = base_path('Surat Keterangan');

        // Reset tabel dokumen
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('dokumen')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Ambil ID kategori
        $katKependudukan = Kategori::where('nama_kategori', 'Surat Keterangan Kependudukan')->first();
        $katSKTM         = Kategori::where('nama_kategori', 'Surat Keterangan Tidak Mampu (SKTM)')->first();
        $katSKU          = Kategori::where('nama_kategori', 'Surat Keterangan Usaha (SKU)')->first();
        $katPertanahan   = Kategori::where('nama_kategori', 'Surat Keterangan Pertanahan')->first();
        $katAhliWaris    = Kategori::where('nama_kategori', 'Surat Keterangan Ahli Waris')->first();
        $katPernyataan   = Kategori::where('nama_kategori', 'Surat Pernyataan')->first();
        $katLainnya      = Kategori::where('nama_kategori', 'Surat Keterangan Lainnya')->first();

        // Ambil ID unit kerja
        $unitAdmin  = null; // Admin tidak punya unit kerja
        $unitPEL    = UnitKerja::where('kode_unit', 'PEL')->first();   // Kasi Pelayanan
        $unitPEM    = UnitKerja::where('kode_unit', 'PEM')->first();   // Kasi Pemerintahan
        $unitKESRA  = UnitKerja::where('kode_unit', 'KESRA')->first(); // Kasi Kesejahteraan
        $unitKEU    = UnitKerja::where('kode_unit', 'KEU')->first();   // Kaur Keuangan
        $unitSEKDES = UnitKerja::where('kode_unit', 'SEKDES')->first(); // Sekretariat Desa

        // Ambil user
        $admin      = User::where('username', 'admin')->first();   // Administrator Sistem
        $sekdes     = User::where('username', 'sekdes')->first() ?? $admin; // Sekretaris Desa
        $opKeuangan = User::where('username', 'kaur_keuangan')->first() ?? $admin;

        // =====================================================================
        // DAFTAR DOKUMEN: [nama_file, judul, nomor, kategori_id, unit_kerja_id, pengunggah_id, tahun]
        // =====================================================================
        $dokumenList = [

            // ------------------------------------------------------------------
            // KASI PELAYANAN (PEL) — Surat kependudukan & SKTM
            // ------------------------------------------------------------------
            [
                'file'       => 'Surat Keterangan Domisili.doc',
                'judul'      => 'Surat Keterangan Domisili',
                'nomor'      => 'SK/DOM/001',
                'kategori'   => $katKependudukan,
                'unit_kerja' => $unitPEL,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'Surat Keterangan Domisili Sek.doc',
                'judul'      => 'Surat Keterangan Domisili (Sekolah)',
                'nomor'      => 'SK/DOM/002',
                'kategori'   => $katKependudukan,
                'unit_kerja' => $unitPEL,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'Surat Keterangan Domisili Lembaga.doc',
                'judul'      => 'Surat Keterangan Domisili Lembaga',
                'nomor'      => 'SK/DOM/003',
                'kategori'   => $katKependudukan,
                'unit_kerja' => $unitPEL,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'Surat Keterangan Domisili Lembaga 2.doc',
                'judul'      => 'Surat Keterangan Domisili Lembaga (Revisi)',
                'nomor'      => 'SK/DOM/004',
                'kategori'   => $katKependudukan,
                'unit_kerja' => $unitPEL,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'Surat  Keterangan Tempat Tinggal & SKU.docx',
                'judul'      => 'Surat Keterangan Tempat Tinggal & SKU',
                'nomor'      => 'SK/TT/001',
                'kategori'   => $katKependudukan,
                'unit_kerja' => $unitPEL,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'Surat  Keterangan Tempat Tinggal & SKU Sek.docx',
                'judul'      => 'Surat Keterangan Tempat Tinggal & SKU (Sekolah)',
                'nomor'      => 'SK/TT/002',
                'kategori'   => $katKependudukan,
                'unit_kerja' => $unitPEL,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'Surat  Keterangan Tempat Tinggal Sek.docx',
                'judul'      => 'Surat Keterangan Tempat Tinggal (Sekolah)',
                'nomor'      => 'SK/TT/003',
                'kategori'   => $katKependudukan,
                'unit_kerja' => $unitPEL,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'Surat Keterangan Tinggal.doc',
                'judul'      => 'Surat Keterangan Tinggal',
                'nomor'      => 'SK/TT/004',
                'kategori'   => $katKependudukan,
                'unit_kerja' => $unitPEL,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'Surat Keterangan Nikah.doc',
                'judul'      => 'Surat Keterangan Nikah',
                'nomor'      => 'SK/NKH/001',
                'kategori'   => $katKependudukan,
                'unit_kerja' => $unitPEL,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'Surat Keterangan Belum Nikah.doc',
                'judul'      => 'Surat Keterangan Belum Nikah',
                'nomor'      => 'SK/BLM-NKH/001',
                'kategori'   => $katKependudukan,
                'unit_kerja' => $unitPEL,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'Surat Keterangan Lahir.docx',
                'judul'      => 'Surat Keterangan Lahir',
                'nomor'      => 'SK/LHR/001',
                'kategori'   => $katKependudukan,
                'unit_kerja' => $unitPEL,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'Surat Kelahiran.xlsx',
                'judul'      => 'Form Surat Kelahiran',
                'nomor'      => 'SK/LHR/002',
                'kategori'   => $katKependudukan,
                'unit_kerja' => $unitPEL,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'Surat Kematian.xls',
                'judul'      => 'Form Surat Kematian',
                'nomor'      => 'SK/MTN/001',
                'kategori'   => $katKependudukan,
                'unit_kerja' => $unitPEL,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'Surat Kematian KOSONG.xls',
                'judul'      => 'Form Surat Kematian (Kosong)',
                'nomor'      => 'SK/MTN/002',
                'kategori'   => $katKependudukan,
                'unit_kerja' => $unitPEL,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'Surat Keterangan Status.doc',
                'judul'      => 'Surat Keterangan Status',
                'nomor'      => 'SK/STS/001',
                'kategori'   => $katKependudukan,
                'unit_kerja' => $unitPEL,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'Surat Keterangan Belum Mempunyai Rumah.doc',
                'judul'      => 'Surat Keterangan Belum Mempunyai Rumah',
                'nomor'      => 'SK/RMH/001',
                'kategori'   => $katKependudukan,
                'unit_kerja' => $unitPEL,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'Surat Keterangan Beda Data.doc',
                'judul'      => 'Surat Keterangan Beda Data',
                'nomor'      => 'SK/BDT/001',
                'kategori'   => $katKependudukan,
                'unit_kerja' => $unitPEL,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'Surat Keterangan Beda Data Sek.doc',
                'judul'      => 'Surat Keterangan Beda Data (Sekolah)',
                'nomor'      => 'SK/BDT/002',
                'kategori'   => $katKependudukan,
                'unit_kerja' => $unitPEL,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'Form KTP.doc',
                'judul'      => 'Formulir Permohonan KTP',
                'nomor'      => 'FORM/KTP/001',
                'kategori'   => $katKependudukan,
                'unit_kerja' => $unitPEL,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'Form KTP LIVI.doc',
                'judul'      => 'Formulir Permohonan KTP (LIVI)',
                'nomor'      => 'FORM/KTP/002',
                'kategori'   => $katKependudukan,
                'unit_kerja' => $unitPEL,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'FORMOLIR KK.docx',
                'judul'      => 'Formulir Permohonan Kartu Keluarga',
                'nomor'      => 'FORM/KK/001',
                'kategori'   => $katKependudukan,
                'unit_kerja' => $unitPEL,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'surat keterangan wali sekolah.docx',
                'judul'      => 'Surat Keterangan Wali Sekolah',
                'nomor'      => 'SK/WALI-SEK/001',
                'kategori'   => $katKependudukan,
                'unit_kerja' => $unitPEL,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'SK Wali Sek.doc',
                'judul'      => 'SK Wali (Sekolah)',
                'nomor'      => 'SK/WALI/002',
                'kategori'   => $katKependudukan,
                'unit_kerja' => $unitPEL,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'SK Wali.doc',
                'judul'      => 'Surat Keterangan Wali',
                'nomor'      => 'SK/WALI/001',
                'kategori'   => $katKependudukan,
                'unit_kerja' => $unitPEL,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],

            // ------------------------------------------------------------------
            // KASI PELAYANAN (PEL) — SKTM
            // ------------------------------------------------------------------
            [
                'file'       => 'SKTM.doc',
                'judul'      => 'Surat Keterangan Tidak Mampu (SKTM)',
                'nomor'      => 'SKTM/001',
                'kategori'   => $katSKTM,
                'unit_kerja' => $unitPEL,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'SKTM Sek.doc',
                'judul'      => 'SKTM untuk Sekolah',
                'nomor'      => 'SKTM/SEK/001',
                'kategori'   => $katSKTM,
                'unit_kerja' => $unitPEL,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'SKTM RS RT.doc',
                'judul'      => 'SKTM Rumah Sakit (RT)',
                'nomor'      => 'SKTM/RS/001',
                'kategori'   => $katSKTM,
                'unit_kerja' => $unitPEL,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'SKTM RS RT 2.doc',
                'judul'      => 'SKTM Rumah Sakit (RT-2)',
                'nomor'      => 'SKTM/RS/002',
                'kategori'   => $katSKTM,
                'unit_kerja' => $unitPEL,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'Berita Acara Pemeriksaan SKTM RS.doc',
                'judul'      => 'Berita Acara Pemeriksaan SKTM RS',
                'nomor'      => 'BA/SKTM/RS/001',
                'kategori'   => $katSKTM,
                'unit_kerja' => $unitPEL,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'SK Verifikasi Data SKTM RS.doc',
                'judul'      => 'SK Verifikasi Data SKTM Rumah Sakit',
                'nomor'      => 'SK/VER/SKTM/001',
                'kategori'   => $katSKTM,
                'unit_kerja' => $unitPEL,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'Surat Keterangan Tidak Mampu.doc',
                'judul'      => 'Surat Keterangan Tidak Mampu (Umum)',
                'nomor'      => 'SKTM/002',
                'kategori'   => $katSKTM,
                'unit_kerja' => $unitPEL,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'Surat Keterangan Miskin Dinsos.docx',
                'judul'      => 'Surat Keterangan Miskin (Dinsos)',
                'nomor'      => 'SKTM/DINSOS/001',
                'kategori'   => $katSKTM,
                'unit_kerja' => $unitPEL,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'FORM DINSOS.xlsx',
                'judul'      => 'Formulir Dinas Sosial',
                'nomor'      => 'FORM/DINSOS/001',
                'kategori'   => $katSKTM,
                'unit_kerja' => $unitPEL,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],

            // ------------------------------------------------------------------
            // KASI KESEJAHTERAAN (KESRA) — SKU & Penghasilan
            // ------------------------------------------------------------------
            [
                'file'       => 'SKU.doc',
                'judul'      => 'Surat Keterangan Usaha (SKU)',
                'nomor'      => 'SKU/001',
                'kategori'   => $katSKU,
                'unit_kerja' => $unitKESRA,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'SKU HENI.doc',
                'judul'      => 'SKU (Sampel: Heni)',
                'nomor'      => 'SKU/002',
                'kategori'   => $katSKU,
                'unit_kerja' => $unitKESRA,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'SKU sugimin.doc',
                'judul'      => 'SKU (Sampel: Sugimin)',
                'nomor'      => 'SKU/003',
                'kategori'   => $katSKU,
                'unit_kerja' => $unitKESRA,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'SKU Mei 2022.doc',
                'judul'      => 'SKU (Mei 2022)',
                'nomor'      => 'SKU/004',
                'kategori'   => $katSKU,
                'unit_kerja' => $unitKESRA,
                'pengunggah' => $admin,
                'tahun'      => 2022,
            ],
            [
                'file'       => 'Surat Keterangan Usaha Sek.doc',
                'judul'      => 'Surat Keterangan Usaha (Sekolah)',
                'nomor'      => 'SKU/SEK/001',
                'kategori'   => $katSKU,
                'unit_kerja' => $unitKESRA,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'Surat Keterangan Usaha Sek 2.doc',
                'judul'      => 'Surat Keterangan Usaha (Sekolah Revisi)',
                'nomor'      => 'SKU/SEK/002',
                'kategori'   => $katSKU,
                'unit_kerja' => $unitKESRA,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'Surat Keterangan Pengahasilan.doc',
                'judul'      => 'Surat Keterangan Penghasilan',
                'nomor'      => 'SK/PGH/001',
                'kategori'   => $katSKU,
                'unit_kerja' => $unitKESRA,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'Surat Keterangan Gaji.doc',
                'judul'      => 'Surat Keterangan Gaji',
                'nomor'      => 'SK/GAJI/001',
                'kategori'   => $katSKU,
                'unit_kerja' => $unitKESRA,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'Surat Keterangan Bekerja Di Luar Kota.doc',
                'judul'      => 'Surat Keterangan Bekerja Di Luar Kota',
                'nomor'      => 'SK/LK/001',
                'kategori'   => $katSKU,
                'unit_kerja' => $unitKESRA,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'Surat Keterangan Bekerja Di Luar Kota mei.doc',
                'judul'      => 'Surat Keterangan Bekerja Di Luar Kota (Mei)',
                'nomor'      => 'SK/LK/002',
                'kategori'   => $katSKU,
                'unit_kerja' => $unitKESRA,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],

            // ------------------------------------------------------------------
            // KASI PEMERINTAHAN (PEM) — Pertanahan
            // ------------------------------------------------------------------
            [
                'file'       => 'Surat Keterangan Tidak Sengketa New.docx',
                'judul'      => 'Surat Keterangan Tidak Sengketa (Baru)',
                'nomor'      => 'SK/TS/001',
                'kategori'   => $katPertanahan,
                'unit_kerja' => $unitPEM,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'Surat Keterangan Tidak Sengketa-Letter C.docx',
                'judul'      => 'Surat Keterangan Tidak Sengketa Letter C',
                'nomor'      => 'SK/TS/LC/001',
                'kategori'   => $katPertanahan,
                'unit_kerja' => $unitPEM,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'Surat Keterangan Tidak Sengketa-Letter C Kosong.docx',
                'judul'      => 'Surat Keterangan Tidak Sengketa Letter C (Kosong)',
                'nomor'      => 'SK/TS/LC/002',
                'kategori'   => $katPertanahan,
                'unit_kerja' => $unitPEM,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'Surat Keterangan Tidak Sengketa-Letter C Sek.docx',
                'judul'      => 'Surat Keterangan Tidak Sengketa Letter C (Sekolah)',
                'nomor'      => 'SK/TS/LC/003',
                'kategori'   => $katPertanahan,
                'unit_kerja' => $unitPEM,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'Surat Keterangan Mutasi Tanah.doc',
                'judul'      => 'Surat Keterangan Mutasi Tanah',
                'nomor'      => 'SK/MT/001',
                'kategori'   => $katPertanahan,
                'unit_kerja' => $unitPEM,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'SURAT KETERANGAN JUAL BELI SEBELUM DIAKTAKAN.doc',
                'judul'      => 'Surat Keterangan Jual Beli Sebelum Diaktakan',
                'nomor'      => 'SK/JB/001',
                'kategori'   => $katPertanahan,
                'unit_kerja' => $unitPEM,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'SURAT KETERANGAN JUAL BELI SEBELUM DIAKTAKAN Kosong.doc',
                'judul'      => 'Surat Keterangan Jual Beli Sebelum Diaktakan (Kosong)',
                'nomor'      => 'SK/JB/002',
                'kategori'   => $katPertanahan,
                'unit_kerja' => $unitPEM,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'Surat Keterangan Data Baru PBB.doc',
                'judul'      => 'Surat Keterangan Data Baru PBB',
                'nomor'      => 'SK/PBB/001',
                'kategori'   => $katPertanahan,
                'unit_kerja' => $unitPEM,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'Surat  Keterangan Bangunan.docx',
                'judul'      => 'Surat Keterangan Bangunan',
                'nomor'      => 'SK/BGN/001',
                'kategori'   => $katPertanahan,
                'unit_kerja' => $unitPEM,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'Surat Persetujuan Tetangga.doc',
                'judul'      => 'Surat Persetujuan Tetangga',
                'nomor'      => 'SK/TTG/001',
                'kategori'   => $katPertanahan,
                'unit_kerja' => $unitPEM,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],

            // ------------------------------------------------------------------
            // SEKRETARIAT DESA (SEKDES) — Ahli Waris
            // ------------------------------------------------------------------
            [
                'file'       => 'Surat Keterangan Ahli Waris.doc',
                'judul'      => 'Surat Keterangan Ahli Waris',
                'nomor'      => 'SK/AW/001',
                'kategori'   => $katAhliWaris,
                'unit_kerja' => $unitSEKDES,
                'pengunggah' => $sekdes,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'Surat Keterangan Ahli Waris 2.doc',
                'judul'      => 'Surat Keterangan Ahli Waris (Revisi)',
                'nomor'      => 'SK/AW/002',
                'kategori'   => $katAhliWaris,
                'unit_kerja' => $unitSEKDES,
                'pengunggah' => $sekdes,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'SURAT PERNYATAAN AHLI WARIS.doc',
                'judul'      => 'Surat Pernyataan Ahli Waris',
                'nomor'      => 'SP/AW/001',
                'kategori'   => $katAhliWaris,
                'unit_kerja' => $unitSEKDES,
                'pengunggah' => $sekdes,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'SURAT PERNYATAAN AHLI WARIS 2.doc',
                'judul'      => 'Surat Pernyataan Ahli Waris (Revisi)',
                'nomor'      => 'SP/AW/002',
                'kategori'   => $katAhliWaris,
                'unit_kerja' => $unitSEKDES,
                'pengunggah' => $sekdes,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'SURAT KUASA AHLI WARIS.doc',
                'judul'      => 'Surat Kuasa Ahli Waris',
                'nomor'      => 'SK/KUASA/AW/001',
                'kategori'   => $katAhliWaris,
                'unit_kerja' => $unitSEKDES,
                'pengunggah' => $sekdes,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'Surat Persetujuan Ahli Waris.doc',
                'judul'      => 'Surat Persetujuan Ahli Waris',
                'nomor'      => 'SK/PRSTJ/AW/001',
                'kategori'   => $katAhliWaris,
                'unit_kerja' => $unitSEKDES,
                'pengunggah' => $sekdes,
                'tahun'      => 2020,
            ],

            // ------------------------------------------------------------------
            // SEKRETARIAT DESA (SEKDES) — Surat Pernyataan
            // ------------------------------------------------------------------
            [
                'file'       => 'SURAT PERNYATAAN BERSAMA.doc',
                'judul'      => 'Surat Pernyataan Bersama',
                'nomor'      => 'SP/BRS/001',
                'kategori'   => $katPernyataan,
                'unit_kerja' => $unitSEKDES,
                'pengunggah' => $sekdes,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'SURAT PERNYATAAN TIDAK MEMILIKI RUMAH.doc',
                'judul'      => 'Surat Pernyataan Tidak Memiliki Rumah',
                'nomor'      => 'SP/RMH/001',
                'kategori'   => $katPernyataan,
                'unit_kerja' => $unitSEKDES,
                'pengunggah' => $sekdes,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'SURAT PERNYATAAN PT.doc',
                'judul'      => 'Surat Pernyataan (PT)',
                'nomor'      => 'SP/PT/001',
                'kategori'   => $katPernyataan,
                'unit_kerja' => $unitSEKDES,
                'pengunggah' => $sekdes,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'SURAT PERNYATAAN Bah Ace.doc',
                'judul'      => 'Surat Pernyataan (Bah Ace)',
                'nomor'      => 'SP/BA/001',
                'kategori'   => $katPernyataan,
                'unit_kerja' => $unitSEKDES,
                'pengunggah' => $sekdes,
                'tahun'      => 2020,
            ],

            // ------------------------------------------------------------------
            // ADMIN — Surat Keterangan Lainnya
            // ------------------------------------------------------------------
            [
                'file'       => 'SKCK.docx',
                'judul'      => 'Surat Keterangan Catatan Kepolisian (SKCK)',
                'nomor'      => 'SKCK/001',
                'kategori'   => $katLainnya,
                'unit_kerja' => null,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'Surat Jalan.doc',
                'judul'      => 'Surat Jalan',
                'nomor'      => 'SK/SJ/001',
                'kategori'   => $katLainnya,
                'unit_kerja' => null,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'Paklaring.docx',
                'judul'      => 'Surat Paklaring (Referensi Kerja)',
                'nomor'      => 'SK/PKL/001',
                'kategori'   => $katLainnya,
                'unit_kerja' => null,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'NA Baru.docx',
                'judul'      => 'Naskah Akademik Baru',
                'nomor'      => 'NA/001',
                'kategori'   => $katLainnya,
                'unit_kerja' => null,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'NA Baru Juli 2020.docx',
                'judul'      => 'Naskah Akademik Baru (Juli 2020)',
                'nomor'      => 'NA/002',
                'kategori'   => $katLainnya,
                'unit_kerja' => null,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'Domjan.docx',
                'judul'      => 'Surat Domisili Janda',
                'nomor'      => 'SK/DOMJAN/001',
                'kategori'   => $katLainnya,
                'unit_kerja' => null,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'Surat  Keterangan Himbauan Bank Emok.docx',
                'judul'      => 'Surat Keterangan Himbauan Bank Emok',
                'nomor'      => 'SK/HIM/001',
                'kategori'   => $katLainnya,
                'unit_kerja' => null,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'Surat Keterangan Izin Rame-rame.doc',
                'judul'      => 'Surat Keterangan Izin Keramaian',
                'nomor'      => 'SK/IZIN/001',
                'kategori'   => $katLainnya,
                'unit_kerja' => null,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'Surat Keterangan ID BDT.docx',
                'judul'      => 'Surat Keterangan ID Basis Data Terpadu (BDT)',
                'nomor'      => 'SK/BDT/003',
                'kategori'   => $katLainnya,
                'unit_kerja' => null,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'SURAT KETERANGAN KIP.docx',
                'judul'      => 'Surat Keterangan Kartu Indonesia Pintar (KIP)',
                'nomor'      => 'SK/KIP/001',
                'kategori'   => $katLainnya,
                'unit_kerja' => null,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'Surat Keterangan Permohonan Subsidi Listrik.doc',
                'judul'      => 'Surat Keterangan Permohonan Subsidi Listrik',
                'nomor'      => 'SK/LISTRIK/001',
                'kategori'   => $katLainnya,
                'unit_kerja' => null,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
            [
                'file'       => 'Kartu Pembelian BBM Bersubsidi.doc.docx',
                'judul'      => 'Kartu Pembelian BBM Bersubsidi',
                'nomor'      => 'SK/BBM/001',
                'kategori'   => $katLainnya,
                'unit_kerja' => null,
                'pengunggah' => $admin,
                'tahun'      => 2020,
            ],
        ];

        // =====================================================================
        // PROSES COPY FILE DAN INSERT DATABASE
        // =====================================================================
        $imported   = 0;
        $skipped    = 0;
        $errors     = [];

        foreach ($dokumenList as $item) {
            $sourceFile = $this->sourceDir . DIRECTORY_SEPARATOR . $item['file'];

            // Cek file sumber ada
            if (!file_exists($sourceFile)) {
                $errors[] = "File tidak ditemukan: {$item['file']}";
                $skipped++;
                continue;
            }

            // Pastikan kategori dan pengunggah valid
            if (!$item['kategori'] || !$item['pengunggah']) {
                $errors[] = "Kategori / pengunggah null untuk: {$item['file']}";
                $skipped++;
                continue;
            }

            $extension  = strtolower(pathinfo($item['file'], PATHINFO_EXTENSION));
            $ukuranKb   = (int) round(filesize($sourceFile) / 1024);
            $tahun      = $item['tahun'];

            // Nama file di storage (slug + random)
            $slug       = \Illuminate\Support\Str::slug($item['judul']);
            $random     = \Illuminate\Support\Str::random(6);
            $namaStorage = "{$tahun}_{$slug}_{$random}.{$extension}";
            $storagePath = "public/documents/{$tahun}/{$namaStorage}";
            $destDir     = storage_path("app/public/documents/{$tahun}");

            // Buat direktori jika belum ada
            if (!is_dir($destDir)) {
                mkdir($destDir, 0755, true);
            }

            // Copy file
            $destFile = $destDir . DIRECTORY_SEPARATOR . $namaStorage;
            if (!copy($sourceFile, $destFile)) {
                $errors[] = "Gagal copy: {$item['file']}";
                $skipped++;
                continue;
            }

            // Tentukan unit kerja (admin bisa null)
            $idUnitKerja = $item['unit_kerja'] ? $item['unit_kerja']->id : null;

            // Insert ke database
            Dokumen::create([
                'id_kategori'    => $item['kategori']->id,
                'id_unit_kerja'  => $idUnitKerja,
                'id_pengunggah'  => $item['pengunggah']->id,
                'nomor_dokumen'  => $item['nomor'],
                'judul_dokumen'  => $item['judul'],
                'deskripsi'      => null,
                'tahun_dokumen'  => $tahun,
                'lokasi_file'    => $storagePath,
                'tipe_file'      => $extension,
                'ukuran_file'    => $ukuranKb,
                'status_retensi' => 'Aktif',
                'tanggal_unggah' => now(),
            ]);

            $imported++;
        }

        // Ringkasan
        $this->command->info("======================================");
        $this->command->info("Import selesai: {$imported} dokumen berhasil.");
        if ($skipped > 0) {
            $this->command->warn("{$skipped} dokumen dilewati.");
            foreach ($errors as $err) {
                $this->command->warn("  - {$err}");
            }
        }
        $this->command->info("======================================");
    }
}
