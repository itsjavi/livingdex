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
$jsonFile = __DIR__ . '/../../vendor/itsjavi/pokemon-data/exports/pokemon-reference.json';
$pokemon = json_decode(file_get_contents($jsonFile), true, 512, JSON_THROW_ON_ERROR);
$excluded = [
    'identifiers' => [
        // non transferable from their own games:
        '025-partner',
        '025-cosplay',
        '025-phd',
        '025-pop-star',
        '025-rock-star',
        '025-belle',
        '025-libre',
        '133-partner',
        '172-spiky-eared',

        // ability-only forms
        '744-own-tempo',

        // non storable (battle only or they need item or they lose form when stored, etc)
        '351-sunny',
        '351-rainy',
        '351-snowy',
        '421-sunshine',
        '487-origin',
        '492-sky',
        '555-zen',
        '555-zen-galar',
        '648-pirouette',
        '658-ash',
        '681-blade',
        '716-active',
        '718-complete',
        '746-school',
        '774',
        '774-meteor',
        '778-busted',
        '800-ultra',
        '845-gulping',
        '845-gorging',
        '875-noice-face',
        '877-hangry-mode',

        // fusions
        '646-black',
        '646-white',
        '800-dusk-mane',
        '800-dawn-wings',

        // unreleased
        '670-eternal',
//        '025-world-cap',
//        '893-dada',
//        '894',
//        '895',
//        '896',
        '898-ice',
        '898-shadow',
    ],
    'regexes' => [
        '/^000-(.*)/', // misc icons
        '/-(mega|mega-x|mega-y|primal)$/',
        '/-(totem|totem-alola|alola-totem)$/', // storable, but in Bank/HOME they lose their custom weight/height
        '/-(gigantamax|gmax|eternamax)$/',
        '/-(crowned-sword|crowned-shield|crowned)$/',
        '/^493-(.*)/', // all Arceus forms
        '/^649-(.*)/', // all Genesect forms
        '/^676-(.*)/', // all Furfrou styles
        '/^773-(.*)/', // all Sylvally forms
    ],
    'base' => [
        '658', // regular greninja, since we will store greninja-batle-bond preferably
    ],
];
$unknownDexNumber = [];

///
/// PROCESSOR:
///

$isExcluded = function (string $slug, $group = 'identifiers', $regexGroup = 'regexes')
use ($excluded): bool {
    if (in_array($slug, $excluded[$group], true)) {
        return true;
    }
    foreach ($excluded[$regexGroup] as $regex) {
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

// detect gigantamax forms
foreach ($pokemon as $i => $pk) {
    if (in_array($pk['pid'], $unknownDexNumber)) {
        $pokemon[$i]['pid'] = '???';
    }
    $nonGigantamaxForms = [];
    $gigantamaxForms = [];

    foreach ($pk['forms'] as $k => $form) {
        $form['_index'] = $k;

        if (in_array('gigantamax', $form['tags']) || in_array('gmax', $form['tags'])) {
            $gigantamaxForms[$form['name']] = $form;
        } else {
            $nonGigantamaxForms[$form['name']] = $form;
        }
    }
    foreach ($nonGigantamaxForms as $form) {
        if (isset($gigantamaxForms[$form['name'] . '-gigantamax'])) {
            $pokemon[$i]['forms'][$form['_index']]['tags'][] = 'has-gigantamax';
            continue;
        }
        if (in_array('base', $form['tags']) && isset($gigantamaxForms[$pk['name'] . '-gigantamax'])) {
            $pokemon[$i]['forms'][$form['_index']]['tags'][] = 'has-gigantamax';
            continue;
        }
        if (in_array('female', $form['tags']) && isset($gigantamaxForms[$pk['name'] . '-gigantamax'])) {
            $pokemon[$i]['forms'][$form['_index']]['tags'][] = 'has-gigantamax';
            continue;
        }
    }
}

$replacements = [
    '/-gigantamax/' => '-gmax',
    '/-female$/' => '-f',
    '/-core$/' => '',
    '/-style$/' => '',
    '/-poke-ball$/' => '-pokeball',
    '/-blue-striped$/' => '-blue-stripe',
];

// process and flatten pokemon forms list
foreach ($pokemon as $i => $pk) {
    foreach ($pk['forms'] as $k => $form) {
        if ($isExcluded($form['name_numeric']) || $isExcluded($form['name_numeric_avatar'])) {
            continue;
        }
        if (in_array('base', $form['tags']) && $isExcluded($form['name_numeric'], 'base')) {
            continue;
        }
        if (in_array('female', $form['tags']) && in_array('has-gigantamax', $form['tags'])) {
            unset($form['tags'][array_search('has-gigantamax', $form['tags'])]);
        }
        $srcDirName = $boxCalc($pk['id'], $imgDirDexSize, $numPadding);
        $slug = $form['name_numeric_avatar'];
        foreach($replacements as $reg => $repl) {
            $slug = preg_replace($reg, $repl, $slug);
        }
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
