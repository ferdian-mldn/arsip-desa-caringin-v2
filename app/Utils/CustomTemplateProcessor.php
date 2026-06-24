<?php

namespace App\Utils;

use PhpOffice\PhpWord\TemplateProcessor;

/**
 * Custom TemplateProcessor yang mengekspos tempDocumentMainPart
 * agar kita bisa melakukan str_replace langsung pada XML untuk
 * penggantian per-karakter pada form KTP (kotak sempit).
 */
class CustomTemplateProcessor extends TemplateProcessor
{
    /**
     * Ambil XML dari dokumen utama
     */
    public function getMainPartXml(): string
    {
        return $this->tempDocumentMainPart;
    }

    /**
     * Set XML dokumen utama
     */
    public function setMainPartXml(string $xml): void
    {
        $this->tempDocumentMainPart = $xml;
    }
}
