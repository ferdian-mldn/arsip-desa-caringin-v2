<?php
// First restore from backup, then redo cleanly
$zip = new ZipArchive;
$file = 'storage/app/templates/form._ktp.docx';
$zip->open($file);
$xml = $zip->getFromName('word/document.xml');
$zip->close();

// Find the RT/RW row
$rtPos = strpos($xml, '>R<');
$trStart = strrpos(substr($xml, 0, $rtPos), '<w:tr ');
$trEnd = strpos($xml, '</w:tr>', $rtPos) + 7;
$trXml = substr($xml, $trStart, $trEnd - $trStart);

// Get all <w:t> tags with their EXACT positions inside the row
preg_match_all('/<w:t([^>]*)>([^<]+)<\/w:t>/', $trXml, $matches, PREG_OFFSET_CAPTURE);

echo "Found " . count($matches[0]) . " text nodes:\n";
foreach ($matches[0] as $i => $m) {
    echo "  [$i] pos=" . $m[1] . " text='" . $matches[2][$i][0] . "'\n";
}

// The correct mapping based on the KTP form layout:
// idx 2 = first digit of RT (hundreds) = RT_1
// idx 3 = second digit of RT (tens)    = RT_2
// idx 4 = third digit of RT (ones)     = RT_3
// idx 7 = first digit of RW (hundreds) = RW_1
// idx 8 = second digit of RW (tens)    = RW_2
// idx 9 = third digit of RW (ones)     = RW_3

// BUT since some digits are the same (e.g. two "0"s), str_replace by value will get confused.
// We must replace by POSITION within the string.

$varMap = [
    2 => '${RT_1}',
    3 => '${RT_2}',
    4 => '${RT_3}',
    7 => '${RW_1}',
    8 => '${RW_2}',
    9 => '${RW_3}',
];

$newTrXml = $trXml;
$delta = 0; // track position shifts due to replacements

// Process in FORWARD order this time, tracking position shift
// First, collect all positions and the replacements
$ops = [];
foreach ($varMap as $idx => $varName) {
    if (!isset($matches[0][$idx])) continue;
    $pos      = $matches[0][$idx][1]; // position in original $trXml
    $original = $matches[0][$idx][0]; // full <w:t...>X</w:t>
    $attrs    = $matches[1][$idx][0];
    $newTag   = '<w:t' . $attrs . '>' . $varName . '</w:t>';
    $ops[] = ['pos' => $pos, 'orig' => $original, 'new' => $newTag];
}

// Sort by position ascending
usort($ops, fn($a, $b) => $a['pos'] - $b['pos']);

// Apply replacements with offset tracking
$delta = 0;
foreach ($ops as $op) {
    $adjustedPos = $op['pos'] + $delta;
    $newTrXml = substr_replace($newTrXml, $op['new'], $adjustedPos, strlen($op['orig']));
    $delta += strlen($op['new']) - strlen($op['orig']);
    echo "Replaced at pos " . $op['pos'] . ": '" . strip_tags($op['orig']) . "' => '" . strip_tags($op['new']) . "'\n";
}

// Verify result
$text = strip_tags($newTrXml);
$text = preg_replace('/\s+/', ' ', $text);
echo "\nFinal TR text: $text\n";

// Save
$newXml = str_replace($trXml, $newTrXml, $xml);
$zip->open($file);
$zip->addFromString('word/document.xml', $newXml);
$zip->close();
echo "\nSaved!\n";
