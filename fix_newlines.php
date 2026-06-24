<?php
$xml = file_get_contents('ktp_xml.txt');
$xml = preg_replace_callback('/(\$\{[^}]+\})/', function($m) {
    // Remove newlines and <w:br/> tags
    $clean = str_replace(["\r", "\n", "<w:br/>", "<w:br />"], "", $m[1]);
    return $clean;
}, $xml);
file_put_contents('ktp_xml_fixed.txt', $xml);
echo "Done\n";
