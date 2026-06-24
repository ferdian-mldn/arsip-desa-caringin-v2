<?php
$xml = file_get_contents('ktp_xml.txt');
if (preg_match('/<w:t>\$<\/w:t>.*?<w:t>1\}<\/w:t>/is', $xml, $matches)) {
    echo $matches[0];
} else {
    echo "No match";
}
