<?php
$zip = new ZipArchive;
$file = 'storage/app/templates/form._ktp.docx';

if ($zip->open($file) === TRUE) {
    $xmlString = $zip->getFromName('word/document.xml');
    
    // We will use regex to find the cells, because DOMDocument might alter other XML namespaces or formatting.
    // We want to find table cells <w:tc> ... </w:tc>
    // Inside the cell, if the text (stripped of tags) matches ${NAMA_X}, ${NIK_X}, or ${KK_X} (ignoring spaces/newlines)
    // We replace the entire cell's <w:p> content with a clean <w:p> that has a single <w:t>
    
    // To do this, let's use preg_replace_callback on <w:tc>...</w:tc>
    $count = 0;
    $xmlString = preg_replace_callback('/<w:tc(\s|>).*?<\/w:tc>/s', function($m) use (&$count) {
        $cellXml = $m[0];
        $text = strip_tags($cellXml);
        $text = preg_replace('/\s+/', '', $text); // remove all whitespace
        
        if (preg_match('/^\${(NAMA|NIK|KK)_(\d+)}$/', $text, $match)) {
            $count++;
            $varName = '${' . $match[1] . '_' . $match[2] . '}';
            
            // We want to reconstruct the cell to just contain the variable in a clean paragraph.
            // But we need to preserve the cell properties <w:tcPr>
            // Let's extract <w:tcPr>...</w:tcPr>
            $tcPr = '';
            if (preg_match('/<w:tcPr>.*?<\/w:tcPr>/s', $cellXml, $prMatch)) {
                $tcPr = $prMatch[0];
            }
            
            // Reconstruct the cell
            $newCell = '<w:tc>' . $tcPr . '<w:p><w:r><w:t>' . $varName . '</w:t></w:r></w:p></w:tc>';
            return $newCell;
        }
        
        return $cellXml;
    }, $xmlString);
    
    $zip->addFromString('word/document.xml', $xmlString);
    $zip->close();
    echo "Fixed $count cells in document.xml\n";
} else {
    echo "Failed to open zip\n";
}
