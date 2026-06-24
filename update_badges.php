<?php
$file = 'resources/views/dokumen/index.blade.php';
$content = file_get_contents($file);

$replacement = <<<'EOD'
@php
    $hash = md5($dok->kategori->nama_kategori);
    $hue = hexdec(substr($hash, 0, 4)) % 360;
@endphp
<span class="inline-flex items-center px-2 sm:px-3 py-1 rounded-full text-xs font-semibold border border-soft-gray shadow-sm" style="background-color: hsl({{ $hue }}, 85%, 85%); color: #000000;">
    {{ $dok->kategori->nama_kategori }}
</span>
EOD;

// We will replace the span elements that render the category badge.
// The span contains `{{ $dok->kategori->nama_kategori }}`

$content = preg_replace(
    '/<span class="inline-flex items-center[^>]*>\s*\{\{\s*\$dok->kategori->nama_kategori\s*\}\}\s*<\/span>/m',
    $replacement,
    $content
);

file_put_contents($file, $content);
echo "Updated badges in $file\n";
