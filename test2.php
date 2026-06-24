<?php
$xml = file_get_contents('ktp_xml.txt');
$count = 0;
$xml = preg_replace_callback('/(<w:r[^>]*>.*?<w:t[^>]*>.*?\$<\/w:t>.*?)(<w:r[^>]*>.*?(NAMA|NIK|KK).*?<\/w:r>)(.*?<w:t[^>]*>.*?\}<\/w:t>.*?<\/w:r>)/s', function($matches) {
    // This is too complex.
}, $xml);
