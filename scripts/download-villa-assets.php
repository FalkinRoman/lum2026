<?php

$base = dirname(__DIR__) . '/public/images/lum/villa';

$assets = [
    'hero.jpg' => 'https://www.figma.com/api/mcp/asset/73b9ae2b-2167-4453-b356-fea80f5d366a',
    'gallery-01.jpg' => 'https://www.figma.com/api/mcp/asset/e0a2ce44-6913-422a-8b51-e47b0892a6e2',
    'gallery-02.jpg' => 'https://www.figma.com/api/mcp/asset/66a0a391-34c2-4df9-8b6e-ae79fa05bb0d',
    'gallery-03.jpg' => 'https://www.figma.com/api/mcp/asset/f0ac64e6-b84f-4996-8bbb-cae90d843002',
    'facilities-left.jpg' => 'https://www.figma.com/api/mcp/asset/d8d59f76-2b1c-4e64-875c-9a006fdb094c',
    'facilities-right.jpg' => 'https://www.figma.com/api/mcp/asset/db0f2145-82c1-43a4-87c9-23ea29efd631',
    'impression/slide-01.jpg' => 'https://www.figma.com/api/mcp/asset/cc32912f-7682-450f-b62b-c452260ec580',
    'impression/slide-02.jpg' => 'https://www.figma.com/api/mcp/asset/c9ae99ad-3815-487d-9e4f-4689e5687fb1',
    'impression/slide-03.jpg' => 'https://www.figma.com/api/mcp/asset/722c8039-7cc4-46f0-995c-cadba7400530',
    'impression/slide-04.jpg' => 'https://www.figma.com/api/mcp/asset/e2731f39-b690-4d73-acad-b6529d521f13',
    'divider-sun.svg' => 'https://www.figma.com/api/mcp/asset/6ef7724b-5608-4a94-be47-79364f4f778e',
];

function streamDownload(string $url, string $dest): bool
{
    $in = fopen($url, 'r', false, stream_context_create([
        'http' => ['follow_location' => 1, 'timeout' => 120],
        'ssl' => ['verify_peer' => true],
    ]));

    if ($in === false) {
        return false;
    }

    $out = fopen($dest, 'w');

    if ($out === false) {
        fclose($in);

        return false;
    }

    stream_copy_to_stream($in, $out);
    fclose($in);
    fclose($out);

    return filesize($dest) > 0;
}

foreach ($assets as $path => $url) {
    $out = $base . '/' . $path;

    if (! is_dir(dirname($out))) {
        mkdir(dirname($out), 0777, true);
    }

    if (streamDownload($url, $out)) {
        echo "OK {$path} (" . filesize($out) . ")\n";
    } else {
        echo "FAIL {$path}\n";
    }
}
