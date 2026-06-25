<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\TemplateSurat;
use Illuminate\Support\Str;
use File;

class TemplateSuratSeeder extends Seeder
{
    public function run()
    {
        // 1. Create templates directory if not exists
        $templateDir = storage_path('app/templates');
        if (!File::exists($templateDir)) {
            File::makeDirectory($templateDir, 0755, true);
        }

        // 2. Source folder
        $sourceDir = base_path('asset/desa');
        $files = File::glob($sourceDir . '/*.docx');

        // Hapus data lama agar tidak menumpuk saat di-seed ulang
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('template_surat')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $mapping = [
            'FORM. KTP' => 'Formulir Pengantar KTP',
            'KET DOMISILI - ktp - terbaru - Copy (2) - Copy - Copy - Copy - Copy' => 'Surat Keterangan Domisili',
            'KET DOMISILI - ktp - terbaru - Copy (2) - Copy - Copy - Copy' => 'Surat Keterangan Domisili (Alt)',
            'SKTM Sekolah New' => 'Surat Keterangan Tidak Mampu (Sekolah)',
            'SKTM.RUMAH SAKIT' => 'Surat Keterangan Tidak Mampu (Rumah Sakit)',
            'SKU New' => 'Surat Keterangan Usaha (SKU)',
            'SURAT PINDAH KAB' => 'Surat Pengantar Pindah Kabupaten',
            'sktm' => 'Surat Keterangan Tidak Mampu (Umum)',
        ];

        foreach ($files as $file) {
            $basename = basename($file);
            if (Str::contains($basename, 'PROFIL DESA') || Str::contains($basename, '(Alt)')) {
                continue;
            }

            // Copy to storage
            $newFilename = str_replace(' ', '_', strtolower($basename));
            $destPath = 'templates/' . $newFilename;
            File::copy($file, storage_path('app/' . $destPath));

            // Determine name
            $namaAsli = str_replace('.docx', '', $basename);
            
            // Skip the duplicate domisili
            if ($namaAsli === 'KET DOMISILI - ktp - terbaru - Copy (2) - Copy - Copy - Copy') {
                continue;
            }

            $namaTemplate = $mapping[$namaAsli] ?? $namaAsli;
            $kodeTemplate = Str::slug($namaTemplate);

            // Create record
            TemplateSurat::create([
                'kode_template' => $kodeTemplate,
                'nama_template' => $namaTemplate,
                'deskripsi' => 'Template dokumen ' . $namaTemplate,
                'lokasi_file' => $destPath,
                'status_aktif' => true,
            ]);
        }
        
        $this->command->info('Template surat berhasil di-seed.');
    }
}
