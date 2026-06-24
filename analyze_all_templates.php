<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// 1. List all template records in DB
echo "=== Templates in Database ===\n";
$templates = DB::table('template_surat')->get();
foreach ($templates as $t) {
    echo "  ID: {$t->id} | Kode: {$t->kode_template} | Nama: {$t->nama_template} | File: {$t->lokasi_file}\n";
}

echo "\n=== Template Files on Disk ===\n";
foreach (glob('storage/app/templates/*.docx') as $f) {
    echo "  - " . basename($f) . "\n";
}

// 2. Check which DB records have missing files
echo "\n=== Missing Files ===\n";
foreach ($templates as $t) {
    $path = storage_path('app/' . $t->lokasi_file);
    if (!file_exists($path)) {
        echo "  MISSING: ID={$t->id} | {$t->nama_template} | {$t->lokasi_file}\n";
    }
}

// 3. Quick content summary of each existing template
echo "\n=== Template Content Summary ===\n";
foreach (glob('storage/app/templates/*.docx') as $f) {
    $zip = new ZipArchive;
    $zip->open($f);
    $xml = $zip->getFromName('word/document.xml');
    $zip->close();
    $text = strip_tags($xml);
    $text = preg_replace('/\s+/', ' ', $text);
    $text = trim($text);
    // Show first 300 chars
    echo "\n--- " . basename($f) . " ---\n";
    echo substr($text, 0, 400) . "\n";
}
