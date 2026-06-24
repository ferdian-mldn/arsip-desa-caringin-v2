<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use ZipArchive;
use App\Models\DataWarga;

class DataWargaSeeder extends Seeder
{
    public function run()
    {
        $file = base_path('asset/desa/DATA PENDUDUK 2024.xlsx');
        
        if (!file_exists($file)) {
            $this->command->error("File Excel tidak ditemukan: $file");
            return;
        }

        $zip = new ZipArchive();
        if ($zip->open($file) !== TRUE) {
            $this->command->error("Gagal membuka file Excel.");
            return;
        }

        // Baca shared strings
        $strings = $zip->getFromName('xl/sharedStrings.xml');
        $sharedStrings = [];
        if ($strings) {
            preg_match_all('/<t[^>]*>([^<]*)<\/t>/', $strings, $matches);
            if (!empty($matches[1])) {
                $sharedStrings = $matches[1];
            }
        }

        // Baca data sheet
        $sheet = $zip->getFromName('xl/worksheets/sheet1.xml');
        $zip->close();

        preg_match_all('/<row[^>]*>(.*?)<\/row>/s', $sheet, $rowMatches);
        $rowCount = count($rowMatches[1]);
        
        $this->command->info("Ditemukan $rowCount baris data. Memulai import...");
        
        // Asumsi format kolom sesuai header di baris pertama
        // A: NO_KK
        // B: ALAMAT
        // C: RT
        // D: RW
        // E: NAMA
        // F: NIK
        // G: JK
        // H: TMPT_LHR
        // I: TGL_LHR
        // J: AGAMA
        // K: STATUS
        // L: PDDK_AKHIR
        // M: PEKERJAAN
        // N: SHDK
        // O: NAMA_IBU
        // P: NAMA_AYAH
        // Q: GDR

        $wargaData = [];
        $batchSize = 500;
        
        // Skip header (i = 0)
        for ($i = 1; $i < $rowCount; $i++) {
            $rowData = [];
            preg_match_all('/<c r="([A-Z]+)\d+"[^>]*(?:t="s")?[^>]*><v>([^<]*)<\/v><\/c>/', $rowMatches[1][$i], $cellMatches, PREG_SET_ORDER);
            
            // Default row data
            $cells = [
                'A' => '', 'B' => '', 'C' => '', 'D' => '', 'E' => '', 'F' => '',
                'G' => '', 'H' => '', 'I' => '', 'J' => '', 'K' => '', 'L' => '',
                'M' => '', 'N' => '', 'O' => '', 'P' => '', 'Q' => ''
            ];
            
            foreach ($cellMatches as $cell) {
                $colIndex = $cell[1];
                $val = $cell[2];
                // Resolve string
                if (strpos($rowMatches[1][$i], 'r="' . $colIndex) !== false && preg_match('/<c r="' . $colIndex . '\d+"[^>]*t="s"[^>]*>/', $rowMatches[1][$i])) {
                    if (isset($sharedStrings[(int)$val])) {
                        $val = $sharedStrings[(int)$val];
                    }
                }
                $cells[$colIndex] = $val;
            }

            // Validasi minimal ada NIK & Nama
            if (empty(trim($cells['F'])) || empty(trim($cells['E']))) {
                continue;
            }
            
            // Konversi tanggal excel ke PHP Date (Excel date system mulai dari 1900-01-01)
            $tglLahir = null;
            if (is_numeric($cells['I']) && $cells['I'] > 0) {
                $unixDate = ($cells['I'] - 25569) * 86400; // 25569 = hari antara 1900 dan 1970
                $tglLahir = gmdate("Y-m-d", $unixDate);
            }

            $wargaData[] = [
                'nik' => substr(preg_replace('/[^0-9]/', '', $cells['F']), 0, 16),
                'no_kk' => substr(preg_replace('/[^0-9]/', '', $cells['A']), 0, 16),
                'nama_lengkap' => substr($cells['E'], 0, 255),
                'jenis_kelamin' => strtoupper($cells['G']) == 'P' ? 'P' : 'L',
                'tempat_lahir' => substr($cells['H'], 0, 100),
                'tanggal_lahir' => $tglLahir,
                'agama' => substr($cells['J'], 0, 50),
                'status_perkawinan' => substr($cells['K'], 0, 50),
                'shdk' => substr($cells['N'], 0, 50),
                'pendidikan_terakhir' => substr($cells['L'], 0, 100),
                'pekerjaan' => substr($cells['M'], 0, 100),
                'nama_ibu' => substr($cells['O'], 0, 255),
                'nama_ayah' => substr($cells['P'], 0, 255),
                'alamat' => substr($cells['B'], 0, 255),
                'rt' => substr($cells['C'], 0, 10),
                'rw' => substr($cells['D'], 0, 10),
                'kelurahan' => 'CARINGIN',
                'kecamatan' => 'GEGERBITUNG',
                'kabupaten' => 'SUKABUMI',
                'provinsi' => 'JAWA BARAT',
                'golongan_darah' => substr($cells['Q'], 0, 5) == '-' ? null : substr($cells['Q'], 0, 5),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Batch insert
            if (count($wargaData) >= $batchSize) {
                DB::table('data_warga')->insertOrIgnore($wargaData);
                $wargaData = [];
                $this->command->info("Inserted batch up to row $i...");
            }
        }
        
        // Insert sisa
        if (count($wargaData) > 0) {
            DB::table('data_warga')->insertOrIgnore($wargaData);
        }

        $this->command->info("Data warga berhasil di-seed.");
    }
}
