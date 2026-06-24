<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\DataWarga;
use App\Models\TemplateSurat;

$warga = DataWarga::where('nik', '3202405209050001')->first();
$surat = TemplateSurat::where('nama_template', 'like', '%KTP%')->first();

if (!$surat) {
    // just fallback to filename directly
    $surat = (object)['file_template' => 'form._ktp.docx'];
}

$templatePath = storage_path('app/templates/' . $surat->file_template);
$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templatePath);

$namaChars = str_split($warga->nama_lengkap);
for ($i = 0; $i < 50; $i++) {
    $char = isset($namaChars[$i]) ? $namaChars[$i] : '';
    $templateProcessor->setValue('NAMA_' . ($i + 1), $char);
}

$outputPath = storage_path('app/public/test_ktp_output.docx');
$templateProcessor->saveAs($outputPath);

// Check XML
$z = new ZipArchive;
$z->open($outputPath);
$outXml = $z->getFromName('word/document.xml');
$z->close();

if (preg_match('/NAMA_1/', $outXml)) {
    echo "FAILED: NAMA_1 is still in output\n";
} else {
    echo "SUCCESS: NAMA_1 was replaced\n";
}
