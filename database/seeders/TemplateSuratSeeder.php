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

        foreach ($files as $file) {
            $basename = basename($file);
            if (Str::contains($basename, 'PROFIL DESA')) {
                continue;
            }

            // Copy to storage
            $newFilename = str_replace(' ', '_', strtolower($basename));
            $destPath = 'templates/' . $newFilename;
            File::copy($file, storage_path('app/' . $destPath));

            // Determine name
            $namaTemplate = str_replace('.docx', '', $basename);
            $kodeTemplate = Str::slug($namaTemplate);

            // Create record
            TemplateSurat::updateOrCreate(
                ['kode_template' => $kodeTemplate],
                [
                    'nama_template' => $namaTemplate,
                    'deskripsi' => 'Template dokumen ' . $namaTemplate,
                    'lokasi_file' => $destPath,
                    'status_aktif' => true,
                ]
            );
        }
        
        $this->command->info('Template surat berhasil di-seed.');
    }
}
