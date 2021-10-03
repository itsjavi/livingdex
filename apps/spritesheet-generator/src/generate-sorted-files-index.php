<?php

require_once __DIR__ . '/functions.php';

$buildDir = pk\build_dir();
$outputDir = pk\output_dir();
$destJsonFile = $outputDir . '/sorted-files-index.json';

// HOME renders
$homeImgSrcDir = pk\home_img_dir();
$homeImgDestDir = $buildDir . '/home-renders';

// MENU icons (pixel art)
$menuImgSrcDir = pk\pokesprite_img_dir();
$menuImgDestDir = $buildDir . '/menu-icons';

if (file_exists($outputDir . '/pokemon-home-regular.png')) {
    echo __FILE__ . ": sprite sheet already generated. Skipping.";
    exit;
}

$imgHomeSrcUnknown = '0000-unknown';
$imgHomeDestUnknown = '0000-002';

$imgMenuSrcUnknown = 'unknown';
$imgMenuDestUnknown = '0000-002';

$formsData = pk\pokemon_data();
$data = [
    'egg' => [
        'imgHomeSrc' => '0000',
        'imgMenuSrc' => 'egg',
        'imgHomeDest' => '0000-000',
        'imgMenuDest' => '0000-000',
    ],
    'egg-manaphy' => [
        'imgHomeSrc' => null,
        'imgMenuSrc' => 'egg-manaphy',
        'imgHomeDest' => null,
        'imgMenuDest' => '0000-001',
    ],
    'unknown' => [
        'imgHomeSrc' => $imgHomeSrcUnknown,
        'imgMenuSrc' => $imgMenuSrcUnknown,
        'imgHomeDest' => $imgHomeDestUnknown,
        'imgMenuDest' => $imgMenuDestUnknown,
    ],
    'unknown-alt' => [
        'imgHomeSrc' => null,
        'imgMenuSrc' => 'unknown-gen5',
        'imgHomeDest' => null,
        'imgMenuDest' => '0000-003',
    ],
    'substitute' => [
        'imgHomeSrc' => '0000-substitute',
        'imgMenuSrc' => null,
        'imgHomeDest' => '0000-004',
        'imgMenuDest' => '0000-004',
    ]
];

$homeSpritesMap = [];
$menuSpritesMap = [];

foreach ($formsData as $pk) {
    $num = str_pad((string)$pk['num'], 4, '0', STR_PAD_LEFT);
    $formOrder = str_pad((string)$pk['formOrder'], 3, '0', STR_PAD_LEFT);
    $slug = $pk['slug'];
    $imgHomeSrc = basename($pk['imgHome']);
    if ($imgHomeSrc === 'unknown') {
        $imgHomeSrc = $imgHomeSrcUnknown;
    }
    $imgMenuSrc = $pk['imgSprite'];

    $imgHomeDest = "{$num}-{$formOrder}";
    $imgMenuDest = $imgHomeDest;

    if ($imgHomeSrc === $imgHomeSrcUnknown) {
        $imgHomeDest = $imgHomeDestUnknown;
    }

    if ($imgMenuSrc === $imgMenuSrcUnknown) {
        $imgMenuDest = $imgMenuDestUnknown;
    }

    if (isset($homeSpritesMap[$imgHomeSrc])) {
        $imgHomeDest = $homeSpritesMap[$imgHomeSrc];
    }

    if (isset($menuSpritesMap[$imgMenuSrc])) {
        $imgMenuDest = $menuSpritesMap[$imgMenuSrc];
    }

    $data[$slug] = [
        'imgHomeSrc' => $imgHomeSrc,
        'imgMenuSrc' => $imgMenuSrc,
        'imgHomeDest' => $imgHomeDest,
        'imgMenuDest' => $imgMenuDest
    ];

    if (!isset($homeSpritesMap[$imgHomeSrc])) {
        $homeSpritesMap[$imgHomeSrc] = $imgHomeDest;
    }

    if (!isset($menuSpritesMap[$imgMenuSrc])) {
        $menuSpritesMap[$imgMenuSrc] = $imgMenuDest;
    }
}

// Check files existence
foreach ($data as $slug => $pk) {
    [$homeRegularFile, $homeShinyFile, $menuRegularFile, $menuShinyFile] = [null, null, null, null];

    if (!is_null($pk['imgHomeSrc'])) {
        $imgHomeSrc = $pk['imgHomeSrc'];
        $homeRegularFile = "{$homeImgDestDir}/regular/{$imgHomeSrc}.png";
        $homeShinyFile = "{$homeImgDestDir}/shiny/{$imgHomeSrc}.png";
    }

    if (!is_null($pk['imgMenuSrc'])) {
        $imgMenuSrc = $pk['imgMenuSrc'];
        $menuRegularFile = "{$menuImgDestDir}/regular/{$imgMenuSrc}.png";
        $menuShinyFile = "{$menuImgDestDir}/shiny/{$imgMenuSrc}.png";
    }

    foreach ([$homeRegularFile, $homeShinyFile, $menuRegularFile, $menuShinyFile] as $file) {
        if ($file === null) {
            continue;
        }
        pk\assert_file_exists($file);
    }
}

$homeFiles = [];
$menuFiles = [];

$files = [
    'home' => [
        'renames' => [],
        'classes' => []
    ],
    'menu' => [
        'renames' => [],
        'classes' => []
    ]
];

foreach ($data as $slug => $pk) {
    $imgHomeSrc = $pk['imgHomeSrc'];
    $imgMenuSrc = $pk['imgMenuSrc'];

    $imgHomeDest = $pk['imgHomeDest'];
    $imgMenuDest = $pk['imgMenuDest'];

    if ($imgHomeSrc !== null) {
        if (!isset($files['home']['renames'][$imgHomeSrc])) {
            $files['home']['renames'][$imgHomeSrc] = $imgHomeDest;
        }
        if (!isset($files['home']['classes'][$imgHomeDest])) {
            $files['home']['classes'][$imgHomeDest] = [$slug];
        } else {
            $files['home']['classes'][$imgHomeDest][] = $slug;
        }
    }

    if ($imgMenuSrc !== null) {
        if (!isset($files['menu']['renames'][$imgMenuSrc])) {
            $files['menu']['renames'][$imgMenuSrc] = $imgMenuDest;
        }
        if (!isset($files['menu']['classes'][$imgMenuDest])) {
            $files['menu']['classes'][$imgMenuDest] = [$slug];
        } else {
            $files['menu']['classes'][$imgMenuDest][] = $slug;
        }
    }
}

$dataJson = json_encode($files, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
file_put_contents($destJsonFile, $dataJson);

