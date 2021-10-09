<?php

require_once __DIR__ . '/functions.php';

$buildDir = pk\build_dir();
$outputDir = pk\output_dir();
$spriteSheetsDir = pk\spritesheets_dir();
$dataFile = $outputDir . '/sorted-files-index.json';
$data = pk\json_decode_file($dataFile);

$generateCssHtml = static function (
    array $classMap,
    string $classPrefix,
    int $spriteSheetWidth,
    int $spriteSheetHeight,
    int $thumbWidth,
    int $thumbHeight,
    int $thumbPadding,
    string $spriteSheetFilename,
    array $spriteSheetFileVariants,
    bool $crispy
) {
    $outerThumbWidth = ($thumbWidth + ($thumbPadding * 2));
    $outerThumbHeight = ($thumbHeight + ($thumbPadding * 2));

    $grid = [[]];
    $maxGridColumns = 32;
    $maxGridRows = 48; // (32 * 48) should be >= count($files)
    $currentGridRow = 0;

    foreach ($classMap as $spriteTileName => $classNames) {
        if (count($grid[$currentGridRow]) >= $maxGridColumns) {
            $currentGridRow++;
            $grid[$currentGridRow] = [];
        }

        $x = count($grid[$currentGridRow]);
        $y = count($grid) - 1;

        $posX = $x * $outerThumbWidth;
        $percentX = ($posX / ($spriteSheetWidth - $outerThumbWidth)) * 100;

        $posY = $y * $outerThumbHeight;
        $percentY = ($posY / ($spriteSheetHeight - $outerThumbHeight)) * 100;

        $grid[$currentGridRow][] = [$classNames, $percentX, $percentY];
    }

    $bgSizeX = $maxGridColumns * 100;
    $bgSizeY = $maxGridRows * 100;

    $extraCss = '';

    if ($crispy) {
        $extraCss = <<< CSS

.{$classPrefix} {
    image-rendering: crisp-edges;
    image-rendering: -moz-crisp-edges;
    image-rendering: -webkit-crisp-edges;
    image-rendering: pixelated;
}

CSS;
    }

    $css = <<<CSS
    
.{$classPrefix} {
    display: inline-block;
    max-width: 100%;
    background-repeat: no-repeat;
    background-image: url({$spriteSheetFilename});
    background-size: {$bgSizeX}% {$bgSizeY}%;
}

CSS;
    $css .= $extraCss;

    foreach ($spriteSheetFileVariants as $variant => $variantFile) {
        $css .= <<<CSS
.{$classPrefix}.{$variant}, .{$variant} .{$classPrefix} {
    background-image: url({$variantFile});
}

CSS;
    }

    $cssTemplate = '%s {background-position: %s %s;}' . PHP_EOL;

    $htmlLayout = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1"/>
    <link rel="stylesheet" href="spritesheet.css">
</head>
<body>
  <div style="position: relative; width: %s;">
     %s
  </div>
</body>
</html>
HTML;
    $transparentImg = pk\create_transparent_data_uri_image($thumbWidth, $thumbHeight);
    $htmlTemplate = "<img title='{%s}' class=\"${classPrefix} ${classPrefix}-%s\" src=\"{$transparentImg}\" />" . PHP_EOL;
    $html = '';

    foreach ($grid as $rowIndex => $row) {
        foreach ($row as $colIndex => $data) {
            [$names, $percentX, $percentY] = $data;

            $cssClasses = array_map(
                function ($slug) use ($classPrefix) {
                    return ".{$classPrefix}-{$slug}";
                },
                $names
            );

            $css .= sprintf(
                $cssTemplate,
                implode(', ', $cssClasses),
                $percentX === 0 ? 0 : "{$percentX}%",
                $percentY === 0 ? 0 : "{$percentY}%"
            );

            foreach ($names as $name) {
                $html .= sprintf($htmlTemplate, $name, $name);
            }
        }
    }

    $html = sprintf($htmlLayout, '75%', $html);

    return [$css, $html];
};

$fileVersion = time();

// HOME renders
[$spriteSheetWidth, $spriteSheetHeight] = getimagesize($spriteSheetsDir . '/pokemon-home-regular.png');
[$homeCss, $homeHtml] = $generateCssHtml(
    $data['home']['classes'],
    'pkm',
    $spriteSheetWidth,
    $spriteSheetHeight,
    64,
    64,
    2,
    'pokemon-home-regular.png?v=' . $fileVersion,
    ['shiny' => 'pokemon-home-shiny.png?v=' . $fileVersion],
    false
);
file_put_contents($spriteSheetsDir . '/pokemon-home.html', $homeHtml);

// MENU icons
[$spriteSheetWidth, $spriteSheetHeight] = getimagesize($spriteSheetsDir . '/pokemon-menu-regular.png');
[$menuCss, $menuHtml] = $generateCssHtml(
    $data['menu']['classes'],
    'pkmi',
    $spriteSheetWidth,
    $spriteSheetHeight,
    68,
    56,
    2,
    'pokemon-menu-regular.png?v=' . $fileVersion,
    ['shiny' => 'pokemon-menu-shiny.png?v=' . $fileVersion],
    true
);
file_put_contents($spriteSheetsDir . '/pokemon-menu.html', $menuHtml);

// Merge CSS styles
file_put_contents($spriteSheetsDir . '/spritesheet.css', $homeCss . PHP_EOL . $menuCss);
