<?php
$zip = new ZipArchive;
$file = 'storage/app/templates/form._ktp.docx';
$zip->open($file);
$xml = $zip->getFromName('word/document.xml');
$zip->close();

// Find the <w:tr> that contains the RT/RW row
$rtPos = strpos($xml, '>R<');
$trStart = strrpos(substr($xml, 0, $rtPos), '<w:tr ');
$trEnd = strpos($xml, '</w:tr>', $rtPos) + 7;
$trXml = substr($xml, $trStart, $trEnd - $trStart);

// Get all <w:t> tags with their text
preg_match_all('/<w:t([^>]*)>([^<]+)<\/w:t>/', $trXml, $matches, PREG_OFFSET_CAPTURE);

// indices 2,3,4 = RT digits; indices 7,8,9 = RW digits
$varMap = [
    2 => '${RT_1}',
    3 => '${RT_2}',
    4 => '${RT_3}',
    7 => '${RW_1}',
    8 => '${RW_2}',
    9 => '${RW_3}',
];

$newTrXml = $trXml;
// Process in reverse order so positions don't shift
$indices = array_keys($varMap);
rsort($indices);
foreach ($indices as $idx) {
    if (!isset($matches[0][$idx])) continue;
    $fullMatch = $matches[0][$idx][0]; // the full <w:t...>X</w:t>
    $attrs     = $matches[1][$idx][0]; // attributes of w:t
    $varName   = $varMap[$idx];
    
    $newTag = '<w:t' . $attrs . '>' . $varName . '</w:t>';
    
    // Replace FIRST occurrence of this exact tag in newTrXml
    $pos = strpos($newTrXml, $fullMatch);
    if ($pos !== false) {
        $newTrXml = substr_replace($newTrXml, $newTag, $pos, strlen($fullMatch));
        echo "Replaced idx $idx: '$fullMatch' => '$newTag'\n";
    } else {
        echo "NOT FOUND idx $idx: $fullMatch\n";
    }
}

// Verify
$text = strip_tags($newTrXml);
$text = preg_replace('/\s+/', ' ', $text);
echo "\nNew TR text: $text\n";

// Save back to docx
$newXml = str_replace($trXml, $newTrXml, $xml);
$zip->open($file);
$zip->addFromString('word/document.xml', $newXml);
$zip->close();
echo "\nSaved to $file!\n";
