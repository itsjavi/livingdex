<?php

// Usage:   cd apps/livingdex-ui/src/data/boxes
//          php boxes-checker.php grouped.json

$boxesFile = $argv[1] ?? null;
$pokemonFormsFile = __DIR__ . '/../../../../../dist/json/gen/8/pokemon-forms.json';

if ($boxesFile === null || !file_exists($boxesFile)) {
    throw new \Exception('Boxes file not passed as first argument or it does not exist: ' . $boxesFile);
}

if (!file_exists($pokemonFormsFile)) {
    throw new \Exception('File does not exist: ' . $pokemonFormsFile);
}


$boxes = json_decode(file_get_contents($boxesFile), true, 512, JSON_THROW_ON_ERROR);
$pokemonForms = json_decode(file_get_contents($pokemonFormsFile), true, 512, JSON_THROW_ON_ERROR);
$pokemonFormsCounter = [];

foreach ($pokemonForms as $pk) {
    if ($pk['isHomeStorable'] === false) {
        continue;
    }
    $slug = $pk['slug'];
    $pokemonFormsCounter[$slug] = 0;
}

foreach ($boxes['boxes'] as $box) {
    foreach ($box['pokemon'] as $slug) {
        if ($slug === null) {
            continue; // empty slot placeholder
        }
        if (!isset($pokemonFormsCounter[$slug])) {
            throw new \Exception("'{$slug}' is not an existing storable Pokemon.");
        }
        $pokemonFormsCounter[$slug]++;
    }
}

foreach ($pokemonFormsCounter as $slug => $total) {
    if ($total <= 0) {
        throw new \Exception("Pokemon '{$slug}' is not present in the given boxes definition file.");
    }
    if ($total > 2) {
        throw new \Exception(
            "Pokemon '{$slug}' appears more than 2 times ({$total}). Try to organize the boxes better to avoid too many duplicates."
        );
    }
}

echo "ALL FINE. ALL STORABLE POKEMON found in {$boxesFile}\n";
