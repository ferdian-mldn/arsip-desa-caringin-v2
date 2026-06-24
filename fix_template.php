<?php
$zip = new ZipArchive;
$file = 'storage/app/templates/form._ktp.docx';

// First, create a backup
copy($file, $file . '.bak');

if ($zip->open($file) === TRUE) {
    $xml = $zip->getFromName('word/document.xml');
    
    // The issue is that the text is wrapped. Word might have inserted newlines or split runs.
    // We want to find any sequence that starts with $ and ends with } and has NAMA_ or NIK_ or KK_ in it.
    // We will strip all tags, newlines, and spaces from it, and wrap it in a single <w:t> tag.
    // However, to avoid breaking XML, we only replace the contents of the matching XML block.
    
    // Find all blocks like <w:t>${NAMA_1</w:t>...<w:t>}</w:t>
    // A regex that starts with <w:t> containing $, and ends with </w:t> where the text inside had }
    $count = 0;
    $xml = preg_replace_callback('/<w:t[^>]*>[^<]*?\$[^<]*?<\/w:t>.*?<w:t[^>]*>[^<]*?\}[^<]*?<\/w:t>/s', function($m) use (&$count) {
        $text = strip_tags($m[0]);
        $text = preg_replace('/\s+/', '', $text); // remove all whitespace/newlines
        if (preg_match('/^\${(NAMA|NIK|KK)_\d+}$/', $text)) {
            $count++;
            return '<w:t>' . $text . '</w:t>';
        }
        return $m[0];
    }, $xml);
    
    // What if the whole ${NAMA_1} is inside a single <w:t> but has newlines?
    $xml = preg_replace_callback('/<w:t([^>]*)>(.*?)<\/w:t>/s', function($m) use (&$count) {
        if (preg_match('/^\s*\${(NAMA|NIK|KK)_\d+}\s*$/s', $m[2])) {
            $clean = preg_replace('/\s+/', '', $m[2]);
            if ($clean !== $m[2]) $count++;
            return '<w:t' . $m[1] . '>' . $clean . '</w:t>';
        }
        return $m[0];
    }, $xml);
    
    $zip->addFromString('word/document.xml', $xml);
    $zip->close();
    echo "Fixed $count variables in docx.\n";
} else {
    echo "Failed to open zip\n";
}
