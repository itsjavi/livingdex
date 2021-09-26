<?php

$generateCss = static function () {
    $baseImgDir = getenv('HOME_RENDERS_DIR') . '/pokemon-edited';
    $srcImgDir = $baseImgDir . '/regular';
    $spriteImgPath = $baseImgDir . '/pokemon-regular.png';
    [$spritesheetWidth, $spritesheetHeight] = getimagesize($spriteImgPath);
    $thumbWidth = 128;
    $thumbHeight = 128;
    $thumbPadding = 2;
    $outerThumbWidth = ($thumbWidth + ($thumbPadding * 2));
    $outerThumbHeight = ($thumbHeight + ($thumbPadding * 1));

    $files = glob($srcImgDir . '/*.png');

    $grid = [[]];
    $maxGridColumns = 32;
    $maxGridRows = 48; // (32 * 48) should be >= count($files)
    $currentGridRow = 0;

    foreach ($files as $file) {
        if (count($grid[$currentGridRow]) >= $maxGridColumns) {
            $currentGridRow++;
            $grid[$currentGridRow] = [];
        }
        $name = basename($file, '.png');

        $x = count($grid[$currentGridRow]);
        $y = count($grid) - 1;

        $posX = $x * $outerThumbWidth;
        $percentX = ($posX / ($spritesheetWidth - $outerThumbWidth)) * 100;

        $posY = $y * $outerThumbHeight;
        $percentY = ($posY / ($spritesheetHeight - $outerThumbHeight)) * 100;

        $grid[$currentGridRow][] = [$name, $percentX, $percentY];
    }

    $bgSizeX = $maxGridColumns * 100;
    $bgSizeY = $maxGridRows * 100;

    $css = <<<CSS
    
.pkm {
    display: inline-block;
    max-width: 100%;
    background-repeat: no-repeat;
    background-image: url(pokemon-regular.png);
    background-size: {$bgSizeX}% {$bgSizeY}%;
}
.shiny.pkm, .shiny .pkm {
    background-image: url(pokemon-shiny.png);
}

CSS;

    $cssTemplate = '.pkm-%s {background-position: %s %s;}' . PHP_EOL;

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
    $transparentImg = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIAAAACAAQMAAAD58POIAAAAA1BMVEX///+nxBvIAAAAAXRSTlMAQObYZgAAABlJREFUeNpjYBgFo2AUjIJRMApGwSigLwAACIAAAcNXzB0AAAAASUVORK5CYII=';
    $htmlTemplate = "<img class=\"pkm pkm-%s\" src=\"{$transparentImg}\" />" . PHP_EOL;
    $html = '';

    foreach ($grid as $rowIndex => $row) {
        foreach ($row as $colIndex => $data) {
            [$name, $percentX, $percentY] = $data;

            $css .= sprintf(
                $cssTemplate,
                $name,
                $percentX === 0 ? 0 : "{$percentX}%",
                $percentY === 0 ? 0 : "{$percentY}%"
            );

            $html .= sprintf($htmlTemplate, $name);
        }
    }

    $html = sprintf($htmlLayout, '75%', $html);

    file_put_contents($baseImgDir . '/spritesheet.css', $css);
    file_put_contents($baseImgDir . '/index.html', $html);
};

$generateCss();
