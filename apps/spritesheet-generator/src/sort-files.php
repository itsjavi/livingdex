<?php

require_once __DIR__ . '/functions.php';

$buildDir = pk\build_dir();
$outputDir = pk\output_dir();
$dataFile = $outputDir . '/sorted-files-index.json';

$homeImgSrcDir = $buildDir . '/home-renders';
$homeImgDestDir = $outputDir . '/home-renders';

$menuImgSrcDir = $buildDir . '/menu-icons';
$menuImgDestDir = $outputDir . '/menu-icons';

if (file_exists($outputDir . '/pokemon-home-regular.png')) {
    echo __FILE__ . ": sprite sheet already generated. Skipping.";
    exit;
}

$data = pk\json_decode_file($dataFile);

$renameFiles = static function (array $fileSet, string $variant, string $srcDir, string $destDir): void {
    foreach ($fileSet as $srcFile => $destFile) {
        $absSrcFile = "{$srcDir}/{$variant}/{$srcFile}.png";
        $absDestFile = "{$destDir}/{$variant}/{$destFile}.png";

        if (!file_exists($absDestFile)) {
            pk\assert_file_exists($absSrcFile);
            copy($absSrcFile, $absDestFile);
            echo "[COPIED] {$absSrcFile}  -> {$absDestFile}\n";
        }
    }
};

$renameFiles($data['home']['renames'], 'regular', $homeImgSrcDir, $homeImgDestDir);
$renameFiles($data['home']['renames'], 'shiny', $homeImgSrcDir, $homeImgDestDir);

$renameFiles($data['menu']['renames'], 'regular', $menuImgSrcDir, $menuImgDestDir);
$renameFiles($data['menu']['renames'], 'shiny', $menuImgSrcDir, $menuImgDestDir);
