<?php

namespace Tools;

use App\Support\Serialization\Encoder\JsonEncoder;

require __DIR__ . '/../../../vendor/autoload.php';

$distDir = getenv('DIST_DIR');
$pokemonListFile = $distDir . '/json/gen/8/pokemon-forms.json';

if (!file_exists($pokemonListFile)) {
    throw new \Exception('File does not exist: ' . $pokemonListFile);
}

$pokemonList = JsonEncoder::decodeFile($pokemonListFile);
$boxes = [['title' => 'Species 1', 'pokemon' => []]];
$currentBox = 0;

foreach ($pokemonList as $poke) {
    if (!$poke['isGmax']) {
        continue;
    }
//    $isFemale = stripos($poke['name'], 'Female') !== false;
//    if (!$isFemale) {
//        continue;
//    }
//    if (($poke['slug'] !== 'minior-red') && ($poke['baseSpecies'] !== null)) {
//        continue;
//    }

    if (count($boxes[$currentBox]['pokemon']) === 30) {
        $currentBox++;
        $boxes[$currentBox] = ['title' => 'Female Forms ' . ($currentBox + 1), 'pokemon' => []];
    }

    $boxes[$currentBox]['pokemon'][] = $poke['slug'];
}

//$currentBox++;
//$formsBox = 1;
//$boxes[$currentBox] = ['title' => 'Forms ' . ($formsBox), 'pokemon' => []];
//foreach ($pokemonList as $poke) {
//    if (!$poke['isHomeStorable']) {
//        continue;
//    }
//    if ($poke['baseSpecies'] === null) {
//        continue;
//    }
//    if (count($boxes[$currentBox]['pokemon']) === 30) {
//        $currentBox++;
//        $formsBox++;
//        $boxes[$currentBox] = ['title' => 'Forms ' . ($formsBox), 'pokemon' => []];
//    }
//
//    $boxes[$currentBox]['pokemon'][] = $poke['slug'];
//}

file_put_contents(__DIR__ . '/boxes.bak.json', JsonEncoder::encode($boxes));
