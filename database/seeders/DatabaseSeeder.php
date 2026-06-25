<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil seeder secara berurutan
        // Urutan PENTING karena User butuh Role dan UnitKerja
        $this->call([
            RoleSeeder::class,
            UnitKerjaSeeder::class,
            KategoriSeeder::class,
            UserSeeder::class,
            TemplateSuratSeeder::class,
            DataWargaSeeder::class,
        ]);
    }
}