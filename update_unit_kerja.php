<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Update existing 7 records based on the organization structure
$updates = [
    1 => ['nama_unit' => 'Sekretaris Desa', 'kode_unit' => 'SEKDES'],
    2 => ['nama_unit' => 'Kaur Keuangan', 'kode_unit' => 'KEU'],
    3 => ['nama_unit' => 'Kaur Administrasi & TU', 'kode_unit' => 'TU'],
    4 => ['nama_unit' => 'Kaur Perencanaan', 'kode_unit' => 'REN'],
    5 => ['nama_unit' => 'Kasi Pemerintahan', 'kode_unit' => 'PEM'],
    6 => ['nama_unit' => 'Kasi Kesra', 'kode_unit' => 'KESRA'],
    7 => ['nama_unit' => 'Kasi Pelayanan Umum', 'kode_unit' => 'PEL'],
];

foreach ($updates as $id => $data) {
    DB::table('unit_kerja')->where('id', $id)->update($data);
}

// Insert viewers if they don't exist
$viewers = [
    ['nama_unit' => 'Kepala Desa', 'kode_unit' => 'KADES'],
    ['nama_unit' => 'Kadus Caringin', 'kode_unit' => 'KADUS1'],
    ['nama_unit' => 'Kadus Kawungluwuk', 'kode_unit' => 'KADUS2'],
    ['nama_unit' => 'Kadus Lio', 'kode_unit' => 'KADUS3'],
    ['nama_unit' => 'Kadus Benjot', 'kode_unit' => 'KADUS4'],
];

foreach ($viewers as $v) {
    if (!DB::table('unit_kerja')->where('nama_unit', $v['nama_unit'])->exists()) {
        DB::table('unit_kerja')->insert([
            'nama_unit' => $v['nama_unit'],
            'kode_unit' => $v['kode_unit'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

echo "Unit Kerja updated!\n";
