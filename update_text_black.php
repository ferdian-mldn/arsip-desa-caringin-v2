<?php
function rglob($pattern, $flags = 0) {
    $files = glob($pattern, $flags); 
    foreach (glob(dirname($pattern).'/*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir) {
        $files = array_merge($files, rglob($dir.'/'.basename($pattern), $flags));
    }
    return $files;
}

$files = rglob('resources/views/*.blade.php');
$changedFiles = 0;

foreach ($files as $file) {
    $content = file_get_contents($file);
    $original = $content;
    
    // Replace text-primary and text-secondary colors to black
    $content = preg_replace('/(\.text-primary\s*\{\s*color:\s*)#[0-9A-Fa-f]+(\s*!important;\s*\})/', '${1}#000000$2', $content);
    $content = preg_replace('/(\.text-secondary\s*\{\s*color:\s*)var\(--secondary\)(\s*;\s*\})/', '${1}#000000$2', $content);
    $content = preg_replace('/(\.text-text-main\s*\{\s*color:\s*)var\(--text-main\)(\s*;\s*\})/', '${1}#000000$2', $content);
    
    // Force text-primary classes to be black directly in blade if needed, but the css class override should work.
    
    // Ensure --text-main is black
    $content = preg_replace('/(--text-main:\s*)#[0-9A-Fa-f]+(;)/', '${1}#000000$2', $content);

    if ($content !== $original) {
        file_put_contents($file, $content);
        $changedFiles++;
    }
}

echo "Changed text colors to black in $changedFiles files.\n";
