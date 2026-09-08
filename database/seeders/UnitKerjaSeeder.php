<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\UnitKerja;

class UnitKerjaSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('unit_kerja')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $units = [
            // Unsur Pimpinan
            ['nama_unit' => 'Kepala Desa',              'kode_unit' => 'KADES'],
            // Unsur Staf / Sekretariat
            ['nama_unit' => 'Sekretaris Desa',           'kode_unit' => 'SEKDES'],
            ['nama_unit' => 'Kaur Keuangan',             'kode_unit' => 'KEU'],
            ['nama_unit' => 'Kaur Perencanaan',          'kode_unit' => 'REN'],
            ['nama_unit' => 'Kaur Administrasi & TU',    'kode_unit' => 'ADM'],
            // Unsur Pelaksana Teknis
            ['nama_unit' => 'Kasi Pemerintahan',         'kode_unit' => 'PEM'],
            ['nama_unit' => 'Kasi Kesejahteraan',        'kode_unit' => 'KESRA'],
            ['nama_unit' => 'Kasi Pelayanan Umum',       'kode_unit' => 'PEL'],
            // Unsur Kewilayahan
            ['nama_unit' => 'Kepala Dusun Lio',          'kode_unit' => 'KADUS1'],
            ['nama_unit' => 'Kepala Dusun Benjot',        'kode_unit' => 'KADUS2'],
            ['nama_unit' => 'Kepala Dusun Kawungluwuk',   'kode_unit' => 'KADUS3'],
            ['nama_unit' => 'Kepala Dusun Caringin',     'kode_unit' => 'KADUS4'],
        ];

        foreach ($units as $unit) {
            UnitKerja::create($unit);
        }
    }
}