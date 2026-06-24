<?php
$zip = new ZipArchive();
$file = 'storage/app/templates/form._ktp.docx';
if ($zip->open($file) === TRUE) {
    $xml = $zip->getFromName('word/document.xml');
    
    // The XML contains something like <w:t>$</w:t><w:br/><w:t>{</w:t><w:br/><w:t>N</w:t>...
    // We want to find the pattern of ${NAMA_X} which might be broken by XML tags
    // Let's just strip all tags inside ${ ... }
    
    // We can use a regex that finds $ followed by { followed by any characters/tags until }
    $xml = preg_replace_callback('/\$[^{]*?\{([^}]+)\}/', function($matches) {
        // Strip XML tags and whitespaces/newlines from the matched content
        $inner = strip_tags($matches[1]);
        $inner = preg_replace('/\s+/', '', $inner);
        return '${' . $inner . '}';
    }, $xml);
    
    // Also remove any <w:br/> inside text nodes that we just made if needed
    // Actually the above callback strips ALL tags between $ and }. 
    // This will break the XML structure because it removes the closing </w:t> for $ and opening <w:t> for }.
    // So we need a smarter approach.
    
    $zip->close();
}
