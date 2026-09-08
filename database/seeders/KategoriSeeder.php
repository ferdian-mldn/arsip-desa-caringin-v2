<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        // Truncate dulu untuk reset kategori lama
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('kategori')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $kategori = [
            // 1. Surat kependudukan dasar
            [
                'nama_kategori' => 'Surat Keterangan Kependudukan',
                'masa_retensi'  => 10,
            ],
            // 2. Surat untuk warga tidak mampu
            [
                'nama_kategori' => 'Surat Keterangan Tidak Mampu (SKTM)',
                'masa_retensi'  => 5,
            ],
            // 3. Surat usaha / penghasilan
            [
                'nama_kategori' => 'Surat Keterangan Usaha (SKU)',
                'masa_retensi'  => 5,
            ],
            // 4. Arsip pertanahan (vital, retensi lama)
            [
                'nama_kategori' => 'Surat Keterangan Pertanahan',
                'masa_retensi'  => 20,
            ],
            // 5. Ahli waris
            [
                'nama_kategori' => 'Surat Keterangan Ahli Waris',
                'masa_retensi'  => 20,
            ],
            // 6. Surat pernyataan
            [
                'nama_kategori' => 'Surat Pernyataan',
                'masa_retensi'  => 5,
            ],
            // 7. Surat lainnya yang tidak masuk kategori di atas
            [
                'nama_kategori' => 'Surat Keterangan Lainnya',
                'masa_retensi'  => 5,
            ],
        ];

        foreach ($kategori as $k) {
            Kategori::create($k);
        }
    }
}