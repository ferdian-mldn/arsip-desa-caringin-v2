<?php
function rglob($pattern, $flags = 0) {
    $files = glob($pattern, $flags); 
    foreach (glob(dirname($pattern).'/*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir) {
        $files = array_merge($files, rglob($dir.'/'.basename($pattern), $flags));
    }
    return $files;
}

$files = rglob('resources/views/*.blade.php');

$replacements = [
    // 1. Rename classes and variables
    'navy-blue' => 'primary',
    'steel-blue' => 'secondary',
    'charcoal' => 'text-main',
    'off-white' => 'bg-app',
    
    // 2. Update HEX values
    '#0A2540' => '#0F9D58', // old navy-blue -> new primary
    '#334E68' => '#34A853', // old steel-blue -> new secondary
    '#111827' => '#1F2937', // old charcoal -> new text-main
    '#F8F9FB' => '#F5F7FA', // old off-white -> new bg-app
    
    // 3. Update RGBA values
    // old navy-blue RGB: 10, 37, 64 -> new primary RGB: 15, 157, 88
    'rgba(10, 37, 64,' => 'rgba(15, 157, 88,',
    // old charcoal RGB: 17, 24, 39 -> new text-main RGB: 31, 41, 55
    'rgba(17, 24, 39,' => 'rgba(31, 41, 55,',
    
    // Add accent variable if needed (though it's not in the original palette mapping)
];

$changedFiles = 0;

foreach ($files as $file) {
    $content = file_get_contents($file);
    $original = $content;
    
    foreach ($replacements as $search => $replace) {
        $content = str_replace($search, $replace, $content);
    }
    
    if ($content !== $original) {
        file_put_contents($file, $content);
        $changedFiles++;
    }
}

echo "Successfully updated colors and class names in $changedFiles blade files.\n";
