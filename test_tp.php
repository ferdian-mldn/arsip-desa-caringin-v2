<?php
require __DIR__ . '/vendor/autoload.php';

$templatePath = 'storage/app/templates/form._ktp.docx';
$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templatePath);

$templateProcessor->setValue('NAMA_1', 'X');
$templateProcessor->setValue('NIK_1', 'Y');
$templateProcessor->setValue('KK_1', 'Z');

$templateProcessor->saveAs('storage/app/templates/test_ktp.docx');
echo "Test KTP saved.\n";
