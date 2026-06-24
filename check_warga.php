<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$cols = DB::getSchemaBuilder()->getColumnListing('data_warga');
echo "Columns in data_warga:\n";
foreach ($cols as $c) { echo "  - $c\n"; }

// Also check sample data for nama_ibu / nama_ayah
$sample = DB::table('data_warga')->select('nik', 'nama_lengkap', 'nama_ibu', 'nama_ayah', 'no_kk')->take(3)->get();
echo "\nSample data:\n";
foreach ($sample as $row) {
    echo "  NIK: {$row->nik} | Nama: {$row->nama_lengkap} | Ibu: {$row->nama_ibu} | Ayah: {$row->nama_ayah} | KK: {$row->no_kk}\n";
}
