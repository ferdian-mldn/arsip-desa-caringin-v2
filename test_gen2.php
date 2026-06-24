<?php
require 'vendor/autoload.php';
require 'bootstrap/app.php';
app()->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$warga = App\Models\DataWarga::where('nik', '3202405209050001')->first();
$tp = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('app/templates/form._ktp.docx'));
$chars = str_split($warga->nama_lengkap);

for ($i=0; $i<50; $i++) {
    $char = $chars[$i] ?? '';
    // If $char is empty, some TemplateProcessor versions might fail. Let's trace it.
    $tp->setValue('NAMA_' . ($i+1), $char);
}

$tp->saveAs(storage_path('app/public/test_ktp_output.docx'));

$z = new ZipArchive;
$z->open(storage_path('app/public/test_ktp_output.docx'));
$out = $z->getFromName('word/document.xml');
$z->close();

if (preg_match('/NAMA_1/', $out)) {
    echo "FAILED: NAMA_1 is still there.\n";
} else {
    echo "SUCCESS: NAMA_1 was replaced.\n";
}

if (preg_match('/NAMA_25/', $out)) {
    echo "FAILED: NAMA_25 is still there.\n";
} else {
    echo "SUCCESS: NAMA_25 was replaced.\n";
}
