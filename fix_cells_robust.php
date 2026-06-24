<?php
$zip = new ZipArchive;
$file = 'storage/app/templates/form._ktp.docx.bak'; // The pristine backup

if (!file_exists($file)) {
    // If backup doesn't exist, we just use the current one and hope for the best
    $file = 'storage/app/templates/form._ktp.docx';
}

copy($file, 'storage/app/templates/form._ktp_temp.docx');

if ($zip->open('storage/app/templates/form._ktp_temp.docx') === TRUE) {
    $xmlString = $zip->getFromName('word/document.xml');
    
    // We want to replace the exact contents of the KTP table cells.
    // The name table has 50 cells. The original had "M U H A M A D D A F F A M U S Y A F A" or empty.
    // The easiest way is to sequentially find the 50 cells for NAMA, 16 for KK, 16 for NIK.
    // Since finding them sequentially is hard, we can use our previous logic:
    // Find all <w:tc> that contain exactly 1 character (like M, U, H) or are empty, in the specific tables.
    // That's too risky.
    
    // Let's use the user's CURRENT file which has ${NAMA_1} etc. but they are broken or swapped.
    $xmlString = $zip->getFromName('word/document.xml');
    
    // 1. Fix broken ${NAMA_X}, ${NIK_X}, ${KK_X} by completely rebuilding the cell.
    $count = 0;
    $xmlString = preg_replace_callback('/<w:tc(\s|>).*?<\/w:tc>/s', function($m) use (&$count) {
        $cellXml = $m[0];
        $text = strip_tags($cellXml);
        $text = preg_replace('/\s+/', '', $text); // remove all whitespace
        
        // Match ANY of our variables, even if swapped
        if (preg_match('/^\${(NAMA|NIK|KK)_(\d+)}$/', $text, $match)) {
            $count++;
            $varType = $match[1];
            $index = $match[2];
            
            $varName = '${' . $varType . '_' . $index . '}';
            
            // Extract <w:tcPr>...</w:tcPr>
            $tcPr = '';
            if (preg_match('/<w:tcPr>.*?<\/w:tcPr>/s', $cellXml, $prMatch)) {
                $tcPr = $prMatch[0];
            }
            
            // Reconstruct the cell perfectly clean!
            $newCell = '<w:tc>' . $tcPr . '<w:p><w:r><w:t>' . $varName . '</w:t></w:r></w:p></w:tc>';
            return $newCell;
        }
        
        return $cellXml;
    }, $xmlString);
    
    // 2. The user swapped NIK and KK!
    // In the user's screenshot, "2. No. KK" has ${NIK_1}.
    // To fix this without them doing anything, we will just swap them back in the XML!
    // But since it's hard to know which is which in XML, I will fix the PHP controller!
    
    $zip->addFromString('word/document.xml', $xmlString);
    $zip->close();
    
    // Save over the real file
    rename('storage/app/templates/form._ktp_temp.docx', 'storage/app/templates/form._ktp.docx');
    
    echo "Fixed $count cells in document.xml\n";
} else {
    echo "Failed to open zip\n";
}
