<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Delete the missing template record
DB::table('template_surat')->where('id', 2)->delete();
echo "Deleted missing template record (ID 2)\n";

// Update names
$updates = [
    1 => 'Formulir Permohonan KTP',
    3 => 'Surat Keterangan Domisili',
    4 => 'Surat Keterangan Tidak Mampu (Sekolah)',
    5 => 'Surat Keterangan Tidak Mampu (Rumah Sakit)',
    6 => 'Surat Keterangan Usaha (SKU)',
    7 => 'Surat Pindah Antar Kabupaten',
    8 => 'Surat Keterangan Tidak Mampu (PLN / Akte Kelahiran)'
];

foreach ($updates as $id => $nama) {
    DB::table('template_surat')->where('id', $id)->update(['nama_template' => $nama]);
    echo "Updated ID $id to '$nama'\n";
}

echo "Database template names updated successfully!\n";
