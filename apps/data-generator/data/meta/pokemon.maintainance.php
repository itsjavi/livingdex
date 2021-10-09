<?php
// Maintainance script to quickly edit data.

namespace Tools;

use App\Support\Serialization\Encoder\JsonEncoder;

require __DIR__ . '/../../vendor/autoload.php';

function array_insert_between(&$array, $beforeKey, $insertMerge)
{
    if (is_int($beforeKey)) {
        array_splice($array, $beforeKey, 0, $insertMerge);
    } else {
        $pos = array_search($beforeKey, array_keys($array), true);
        $array = array_merge(
            array_slice($array, 0, $pos),
            $insertMerge,
            array_slice($array, $pos)
        );
    }
}

if (!file_exists(__DIR__ . '/pokemon.json')) {
    throw new \Exception('File does not exist: ' . __DIR__ . '/pokemon-legacy.json');
}

function save_json(array $data, string $filename)
{
    file_put_contents(
        $filename,
        JsonEncoder::encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE, 2, 3)
    );
}

$pokedex = JsonEncoder::decode(file_get_contents(__DIR__ . '/pokemon.json'));

foreach ($pokedex as $slug => $pk) {
//    $pokedex[$slug]['is_female'] = ($pk['form_slug'] === 'female');

//    unset($pokedex[$slug]['sorting_order']);

//    if (stripos($pk['form_slug'] . '', 'gmax') !== false) {
//        $pokedex[$slug]['is_gmax'] = true;
//        $pokedex[$slug]['is_home_storable'] = false;
//        $pokedex[$slug]['is_home_registrable'] = true;
//    }

//    unset($pokedex[$slug]['isGmax'], $pokedex[$slug]['isHomeStorable'], $pokedex[$slug]['isHomeRegistrable']);

//    array_insert_between($pokedex[$slug], 'changes_from', ['base_forms' => $pk['changes_from']]);
//    unset($pokedex[$slug]['changes_from']);
}

save_json($pokedex, __DIR__ . '/pokemon.json');
