<?php
$xml = file_get_contents('ktp_xml.txt');
preg_match_all('/<w:t[^>]*>(.*?)<\/w:t>/is', $xml, $matches);
foreach ($matches[1] as $match) {
    if (strpos($match, '$') !== false || strpos($match, '{') !== false || strpos($match, 'N') !== false || strpos($match, 'A') !== false || strpos($match, '_') !== false || strpos($match, '1') !== false) {
        echo $match . "\n";
    }
}
