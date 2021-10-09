<?php

namespace pk;

error_reporting(-1);

function create_transparent_data_uri_image($w = 1, $h = 1): string
{
    // Enable output buffering
    ob_start();
    $img = \imagecreatetruecolor($w, $h);

    // Transparent Background
    imagealphablending($img, false);
    $transparency = imagecolorallocatealpha($img, 0, 0, 0, 127);
    imagefill($img, 0, 0, $transparency);
    imagesavealpha($img, true);

    //create image palette with one color, the dithering (the second argument) doesn't matter here
    //\imagetruecolortopalette($img, false, 1);
    \imagepng($img, null, 9); //set the compression level to highest
    \imagedestroy($img);

    // Capture the output
    $imagedata = ob_get_clean();

    return 'data:image/png;base64,' . base64_encode($imagedata);
}

function assert_file_exists($file): void
{
    if ($file === null) {
        throw new \Exception("File name is null");
    }
    if (!file_exists($file)) {
        throw new \Exception("File {$file} does not exist");
    }
    if (!is_readable($file)) {
        throw new \Exception("File {$file} is not readable");
    }
    if (!is_file($file)) {
        throw new \Exception("Path {$file} is not a file");
    }
}

function json_decode_file(string $file): array
{
    if (!file_exists($file)) {
        throw new \JsonException("File {$file} does not exist");
    }
    $json = file_get_contents($file);
    return json_decode($json, true, 512, JSON_THROW_ON_ERROR);
}

function pokemon_data(): array
{
    return json_decode_file(getenv('POKEMON_JSON_FILE'));
}

function pokemon_meta_data(): array
{
    return json_decode_file(getenv('POKEMON_META_JSON_FILE'));
}

function home_img_dir(): string
{
    return getenv('HOME_IMG_DIR');
}

function pokesprite_img_dir(): string
{
    return getenv('POKESPRITE_IMG_DIR');
}

function build_dir(): string
{
    return realpath(__DIR__ . '/../build');
}

function output_dir(): string
{
    return build_dir() . '/output';
}

function spritesheets_dir(): string
{
    return getenv('SPRITESHEETS_DIR');
}

function copy_dir($sourceDir, $destDir): \Generator
{
    if (is_dir($destDir)) {
        return;
    }

    mkdir($destDir, 0755, true);

    /**
     * @var \RecursiveDirectoryIterator $sourceDirIterator
     */
    $sourceDirIterator = new \RecursiveIteratorIterator(
        new \RecursiveDirectoryIterator($sourceDir, \RecursiveDirectoryIterator::SKIP_DOTS),
        \RecursiveIteratorIterator::SELF_FIRST
    );

    foreach ($sourceDirIterator as $item) {
        /** @var \SplFileInfo $item */
        if ($item->isDir()) {
            mkdir($destDir . DIRECTORY_SEPARATOR . $sourceDirIterator->getSubPathname());
        } else {
            copy($item, $destDir . DIRECTORY_SEPARATOR . $sourceDirIterator->getSubPathname());
            yield $item->getRealPath();
        }
    }
}
