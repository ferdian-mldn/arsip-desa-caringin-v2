<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Check distinct shdk values
$shdkValues = DB::table('data_warga')->select('shdk')->distinct()->pluck('shdk');
echo "Distinct SHDK values:\n";
foreach ($shdkValues as $s) { echo "  '$s'\n"; }

// Test: find KK members for a sample NIK
echo "\nTest family lookup for NIK 3202405209050001:\n";
$warga = DB::table('data_warga')->where('nik', '3202405209050001')->first();
if ($warga) {
    echo "  Siswa: {$warga->nama_lengkap} (shdk: {$warga->shdk}) KK: {$warga->no_kk}\n";
    $family = DB::table('data_warga')->where('no_kk', $warga->no_kk)->get(['nik', 'nama_lengkap', 'shdk', 'tempat_lahir', 'tanggal_lahir']);
    foreach ($family as $f) {
        echo "  - {$f->nama_lengkap} | shdk: {$f->shdk} | NIK: {$f->nik}\n";
    }
}
