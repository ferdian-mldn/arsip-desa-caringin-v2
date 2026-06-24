<?php
$zip = new ZipArchive;
$zip->open('storage/app/templates/form._ktp.docx');
$xml = $zip->getFromName('word/document.xml');
$zip->close();

// Replace hardcoded RT digits (0, 2, 6) with variables
// RT is 3 digits - needs RT_1, RT_2, RT_3
// RW is 3 digits - needs RW_1, RW_2, RW_3

// Strategy: find the exact text nodes containing "0", "2", "6" for RT 
// and "0", "0", "7" for RW in that row.
// We'll do it by modifying cells that contain single hardcoded digits in the RT/RW table row.

// The approach: Find the full row with R T label and replace the digit cells.
// From the XML we can see pattern: <w:t>R</w:t>...<w:t>T</w:t>...<w:t>0</w:t><w:t>2</w:t><w:t>6</w:t>...<w:t>R</w:t><w:t>W</w:t>...<w:t>0</w:t><w:t>0</w:t><w:t>7</w:t>

// Find the <w:tr> that contains the RT row
// by looking for RT followed by the digit cells

// Let's find the table row that contains both "R" "T" labels and the digit boxes
// We'll extract a larger chunk around position 58990

$rtPos = strpos($xml, '>R<');
// Find the <w:tr> before this position
$trStart = strrpos(substr($xml, 0, $rtPos), '<w:tr ');
$trEnd = strpos($xml, '</w:tr>', $rtPos) + 7;
$trXml = substr($xml, $trStart, $trEnd - $trStart);

echo "TR XML (text only): ";
$text = strip_tags($trXml);
$text = preg_replace('/\s+/', ' ', $text);
echo $text . "\n\n";

// Count individual text nodes
preg_match_all('/<w:t[^>]*>([^<]+)<\/w:t>/', $trXml, $matches);
echo "Text nodes in this row:\n";
foreach ($matches[1] as $idx => $t) {
    echo "  [$idx]: '$t'\n";
}
