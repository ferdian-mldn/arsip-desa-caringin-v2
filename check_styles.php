<?php
$content = file_get_contents('resources/views/admin/users/create.blade.php');
if (preg_match('/<style>(.*?)<\/style>/s', $content, $matches)) {
    echo $matches[1];
}
