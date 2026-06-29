<?php

$base = dirname(__DIR__) . '/public/images/lum';

$assets = [
    'hero/video-poster.png' => 'local',
    'hero/video.mp4' => 'local',
    'hero/hero-bg.jpg' => 'https://www.figma.com/api/mcp/asset/05c74586-0c87-4a69-83d0-3693cf10ac73',
    'hero/logo-lum-cream.svg' => 'https://www.figma.com/api/mcp/asset/c0265c32-1142-439b-ac36-ae7b7973a815',
    'hero/burger.svg' => 'https://www.figma.com/api/mcp/asset/8f16c516-7670-4b7d-9ee5-9ff15896b2cf',
    'hero/language.svg' => 'https://www.figma.com/api/mcp/asset/8d89cebe-fa92-44ff-9e2e-9ec8793c7631',
    'hero/arrow.svg' => 'https://www.figma.com/api/mcp/asset/00853344-ade7-42a3-adcc-48ea01dc35c6',
    'hero/torn-edge.svg' => 'https://www.figma.com/api/mcp/asset/544ec40f-92b5-481b-84a4-709afb0bf42d',
    'hero/logomark.svg' => 'https://www.figma.com/api/mcp/asset/8aae8e6f-e994-40ac-9daf-9b4d7374f771',
    'hero/deco-left.svg' => 'https://www.figma.com/api/mcp/asset/89dbc9fa-4205-46d6-9269-14fdbcc1f894',
    'hero/deco-right.svg' => 'https://www.figma.com/api/mcp/asset/0baa7ea7-f213-4e0e-9889-65fed89474af',
    'hero/scroll-arrow.svg' => 'https://www.figma.com/api/mcp/asset/e20c56c8-092f-4a41-bced-7d5955496dc8',
    'polaroids/frame.svg' => 'https://www.figma.com/api/mcp/asset/79d4abab-a0de-47ef-82a3-380de5a2e774',
    'polaroids/photo-1.jpg' => 'https://www.figma.com/api/mcp/asset/006241d9-1e61-43f1-a30b-65fa8c667f62',
    'polaroids/photo-2.jpg' => 'https://www.figma.com/api/mcp/asset/0b4054ca-5568-48bb-ba78-ac3dceddac89',
    'polaroids/photo-3.jpg' => 'https://www.figma.com/api/mcp/asset/b1114d89-6263-4250-98d0-0be80757262d',
    'ui/dot.svg' => 'https://www.figma.com/api/mcp/asset/4f5d55be-c663-4fa0-9713-5b156316de35',
    'ui/point-active.svg' => 'https://www.figma.com/api/mcp/asset/bb1850e5-7312-403d-a4e8-e6fca4ef0a45',
    'villas/section.jpg' => 'https://www.figma.com/api/mcp/asset/7d79ef5d-ff5d-4452-8060-2d0017def57f',
    'villas/photo.jpg' => 'https://www.figma.com/api/mcp/asset/50465371-b513-4ace-8d5b-2080cb6ef675',
    'villas/divider.svg' => 'https://www.figma.com/api/mcp/asset/d3a9776c-584a-4fd7-8f8c-817aab798a44',
    'villas/arrow.svg' => 'https://www.figma.com/api/mcp/asset/930811eb-2398-41d1-8bf7-69605040222c',
    'location/dining.webp' => 'https://www.figma.com/api/mcp/asset/1b86608e-27c9-4731-8cd6-041a0551234f',
    'location/card-dining.jpg' => 'https://www.figma.com/api/mcp/asset/0b4054ca-5568-48bb-ba78-ac3dceddac89',
    'location/card-yoga.jpg' => 'https://www.figma.com/api/mcp/asset/c113d3c6-4cd4-4fbf-82fb-0f57a069ec21',
    'location/card-discover.jpg' => 'https://www.figma.com/api/mcp/asset/c05acd2d-cf9f-48e3-90f6-62cb70557fb3',
    'location/pin-photo.jpg' => 'https://www.figma.com/api/mcp/asset/4bbd0199-fbc6-4323-b7de-71c79da5aa33',
    'location/relax-sun.svg' => 'https://www.figma.com/api/mcp/asset/6ac4a21d-37c9-4772-9ed2-e1049b7caf04',
    'location/decor.svg' => 'https://www.figma.com/api/mcp/asset/0b939bc4-2f98-483a-8293-3641b92cd4e9',
    'location/divider.svg' => 'https://www.figma.com/api/mcp/asset/faee9db8-0ed9-4d99-9c4b-d690614fc8db',
    'location/dining-bg.svg' => 'https://www.figma.com/api/mcp/asset/6472573d-9ead-45ee-9e86-870d3bc43c10',
    'interior/left.jpg' => 'https://www.figma.com/api/mcp/asset/3574e5d8-bce9-457f-8288-8bfebc2270c8',
    'interior/right.jpg' => 'https://www.figma.com/api/mcp/asset/5bd994f7-cbcc-4b2d-8c0d-6b425b02f90e',
    'interior/slide-03.jpg' => 'https://www.figma.com/api/mcp/asset/722c8039-7cc4-46f0-995c-cadba7400530',
    'interior/slide-04.jpg' => 'https://www.figma.com/api/mcp/asset/e2731f39-b690-4d73-acad-b6529d521f13',
    'interior/logomark.svg' => 'https://www.figma.com/api/mcp/asset/ba5d3a50-c346-475a-9084-7143d87ea635',
    'interior/arrow.svg' => 'https://www.figma.com/api/mcp/asset/b2741e2a-3d2b-4301-a4a4-d6bb98479eab',
    'interior/slider-active.svg' => 'https://www.figma.com/api/mcp/asset/e37bf07f-71ae-40a9-9c24-af44517f63ce',
    'blog/surfing.jpg' => 'https://www.figma.com/api/mcp/asset/c916678b-8cc5-484c-b7d7-3d0b8b2c38b3',
    'blog/top-wave.svg' => 'https://www.figma.com/api/mcp/asset/14702c61-9d23-440d-bb19-33cc0b47720f',
    'blog/deco-left.svg' => 'https://www.figma.com/api/mcp/asset/b2657ce3-5464-4904-bb65-1f565651d541',
    'blog/deco-right.svg' => 'https://www.figma.com/api/mcp/asset/8e6a13b0-a76d-4c4c-857b-d1a1eb9b6d38',
    'blog/underline.svg' => 'https://www.figma.com/api/mcp/asset/cc0af0ad-5e3f-4698-a19f-81d736c5dab9',
    'shop/bg.jpg' => 'https://www.figma.com/api/mcp/asset/9176fd27-19e0-4580-a201-0ea72992d21a',
    'shop/logomark.svg' => 'https://www.figma.com/api/mcp/asset/6ac4a21d-37c9-4772-9ed2-e1049b7caf04',
    'shop/deco-left.svg' => 'https://www.figma.com/api/mcp/asset/dbad3ff6-9331-4789-acd7-ecff4cfa329a',
    'shop/deco-right.svg' => 'https://www.figma.com/api/mcp/asset/384f211d-0247-47a9-b37c-c4e3be9bdfd4',
    'footer/bg.jpg' => 'https://www.figma.com/api/mcp/asset/a83efee2-9c90-4ca6-8ede-196b82674d37',
    'footer/logomark.svg' => 'https://www.figma.com/api/mcp/asset/a9a680ae-5d20-4a13-a662-33b118a10d97',
    'footer/instagram.svg' => 'https://www.figma.com/api/mcp/asset/0f1ce140-8695-4d6b-91c0-4a231974b9d4',
    'footer/arrow-up.svg' => 'https://www.figma.com/api/mcp/asset/8bb39865-ba6d-42bf-9de6-cd5b95eb00b3',
    'footer/star-full.svg' => 'https://www.figma.com/api/mcp/asset/fb32567f-2515-498d-8264-eaf780eae6cf',
    'footer/star-half.svg' => 'https://www.figma.com/api/mcp/asset/d148dfa0-993a-43af-b1d4-64f8efc14fc5',
    'footer/link-underline.svg' => 'https://www.figma.com/api/mcp/asset/4b05e684-0382-492d-a89f-40871d6269dc',
    'polaroids/bg-texture.webp' => 'https://www.figma.com/api/mcp/asset/e4acbee4-f237-44dc-88eb-303fc8e46495',
    'villas/side-blur.jpg' => 'https://www.figma.com/api/mcp/asset/c7897ed9-0774-4a5e-b3e5-90190fd77ba9',
    'swap/map.jpg' => 'https://www.figma.com/api/mcp/asset/1da20543-55ac-49b9-8319-b1b531fab107',
    'swap/preview.webp' => 'https://www.figma.com/api/mcp/asset/cc678cc0-4e77-4d98-89c5-264fcdbaf9aa',
    'menu/map.jpg' => 'https://www.figma.com/api/mcp/asset/1da20543-55ac-49b9-8319-b1b531fab107',
    'menu/close.svg' => 'https://www.figma.com/api/mcp/asset/8f16c516-7670-4b7d-9ee5-9ff15896b2cf',
    'menu/logo-lum-espresso.svg' => 'https://www.figma.com/api/mcp/asset/c0265c32-1142-439b-ac36-ae7b7973a815',
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
    if ($url === 'local') {
        echo "SKIP {$path} (local)\n";
        continue;
    }
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
