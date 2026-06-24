<?php
$xml = file_get_contents('ktp_xml.txt');
$count = 0;
$xml = preg_replace_callback('/(\$|<w:t>\$<\/w:t>).*?(NAMA|NIK|KK).*?(\}|<w:t>\}<\/w:t>)/s', function($matches) use (&$count) {
    $text = strip_tags($matches[0]);
    $text = preg_replace('/\s+/', '', $text);
    if (preg_match('/^\${(NAMA|NIK|KK)_\d+}$/', $text)) {
        $count++;
        return '<w:t>' . $text . '</w:t>';
    }
    return $matches[0];
}, $xml);
echo "Fixed $count variables\n";
