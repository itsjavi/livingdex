<?php
///
/// CONFIG:
///
///
$numPadding = 3; // number of left leading zeros for file and dir names
$boxRowSize = 5;
$boxColSize = 6;
$boxSize = $boxRowSize * $boxColSize; // = 30
$imgDirDexSize = 100; // max dex numbers per image folder
$jsonFile = __DIR__ . '/../../vendor/route1rodent/pokemon-data/exports/pokemon-reference.json';
$pokemon = json_decode(file_get_contents($jsonFile), true, 512, JSON_THROW_ON_ERROR);
$excluded = [
    'non_transferable' => [
        '025-partner',
        '025-cosplay',
        '025-phd',
        '025-pop-star',
        '025-rock-star',
        '025-belle',
        '025-libre',
        '133-partner',
        '172-spiky-eared',
    ],
    'non_storable' => [
        '351-sunny',
        '351-rainy',
        '351-snowy',
        '421-sunshine',
        '487-origin',
        '492-sky',
        '648-pirouette',
        '670-eternal',
        '681-blade',
        '716-active',
        '718-complete',
        '720-unbound',
        '746-school',
        '778-busted',
        '800-ultra',
        '845-gulping',
        '845-gorging',
        '875-noice-face',
        '877-hangry-mode',
    ],
    'non_storable__regex' => [
        '/^000-(.*)/',
        '/-(mega|mega-x|mega-y|primal)$/',
        '/-(totem|totem-alola|alola-totem)$/',
        '/-(gigantamax|eternamax)$/',
        '/-(crowned-sword|crowned-shield)$/',
        '/^493-(.*)/',
        '/^649-(.*)/',
        '/^676-(.*)/',
        '/^773-(.*)/',
    ],
];


///
/// PROCESSOR:
///

$isExcluded = function (string $slug) use ($excluded): bool {
    if (in_array($slug, $excluded['non_transferable'], true)) {
        return true;
    }
    if (in_array($slug, $excluded['non_storable'], true)) {
        return true;
    }
    foreach ($excluded['non_storable__regex'] as $regex) {
        if ((preg_match($regex, $slug) > 0)) {
            return true;
        }
    }
    return false;
};

$boxCalc = function (int $id, int $boxSize, int $numPadding): string {
    $boxStart = (intval($id % $boxSize) > 0) ?
        ((intval($id / $boxSize) * $boxSize) + 1) :
        (((intval($id / $boxSize) - 1) * $boxSize) + 1);
    $boxEnd = $boxStart + ($boxSize - 1);

    $boxStart = str_pad($boxStart . '', $numPadding, '0', STR_PAD_LEFT);
    $boxEnd = str_pad($boxEnd . '', $numPadding, '0', STR_PAD_LEFT);
    return "{$boxStart}-{$boxEnd}";
};

// collect boxes

$currentBox = 0;
$currentBoxRow = -1;
$currentBoxCol = -1;
$pokemonFormsFlatten = [];
$boxes = [];

// process and flatten pokemon forms list
foreach ($pokemon as $i => $pk) {
    foreach ($pk['forms'] as $k => $form) {
        if ($isExcluded($form['name_numeric']) || $isExcluded($form['name_numeric_avatar'])) {
            continue;
        }
        $srcDirName = $boxCalc($pk['id'], $imgDirDexSize, $numPadding);
        $slug = $form['name_numeric_avatar'];
        $form['id'] = $pk['id'];
        $form['pid'] = $pk['pid'];
        $form['image'] = "media/renders/{$srcDirName}/{$slug}.png";
        $form['image_shiny'] = "media/renders/shiny/{$srcDirName}/{$slug}.png";
        $pokemonFormsFlatten[] = $form;
    }
}

$pokemonFormsFlattenCount = count($pokemonFormsFlatten);
$pokemonFormsFlattenIndex = 0;
$boxIndex = 0;

while (isset($pokemonFormsFlatten[$pokemonFormsFlattenIndex])) {
    $box = [
        'id' => $boxIndex + 1,
        'rows' => [],
    ];
    for ($row = 0; $row < $boxRowSize; $row++) {
        if (!isset($pokemonFormsFlatten[$pokemonFormsFlattenIndex])) {
            break;
        }
        $rowData = [
            'id' => $row + 1,
            'pokemon' => [],
        ];
        for ($col = 0; $col < $boxColSize; $col++) {
            if (!isset($pokemonFormsFlatten[$pokemonFormsFlattenIndex])) {
                break;
            }
            $rowData['pokemon'][$col] = $pokemonFormsFlatten[$pokemonFormsFlattenIndex];
            $pokemonFormsFlattenIndex++;
        }
        $box['rows'][$row] = $rowData;
    }
    $boxes[$boxIndex] = $box;
    $boxIndex++;
}


echo json_encode(['boxes' => $boxes], JSON_PRETTY_PRINT);
