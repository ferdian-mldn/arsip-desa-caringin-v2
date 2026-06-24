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
    
    // Insert --accent into :root
    if (!strpos($content, '--accent')) {
        $content = preg_replace('/(:root\s*\{)/', "$1 --accent: #FFD600;", $content);
        
        // Also let's update some hover states or prominent buttons if possible? No, adding the variable is enough for now. 
        // Let's just define the class
        if (preg_replace('/(<\/style>)/', "    .bg-accent { background-color: var(--accent); }\n    .text-accent { color: var(--accent); }\n$1", $content, -1, $count) && $count > 0) {
            $content = preg_replace('/(<\/style>)/', "    .bg-accent { background-color: var(--accent); }\n    .text-accent { color: var(--accent); }\n$1", $content);
        }
    }
    
    if ($content !== $original) {
        file_put_contents($file, $content);
        $changedFiles++;
    }
}

echo "Added accent variables to $changedFiles files.\n";
