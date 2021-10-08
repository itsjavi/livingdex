<?php // This is just a one-off script.

namespace Tools;

use App\Support\Serialization\Encoder\JsonEncoder;
use App\Support\Serialization\StrFormat;

require __DIR__ . '/../../vendor/autoload.php';

if (!file_exists(__DIR__ . '/pokemon.json')) {
    throw new \Exception('File does not exist: ' . __DIR__ . '/pokemon-legacy.json');
}

$showdownDex = JsonEncoder::decode(file_get_contents(getenv('SOURCES_DIR') . '/showdown-data/dist/data/pokedex.json'));
$showdownDex = $showdownDex['Pokedex'];
$extraData = JsonEncoder::decode(file_get_contents(__DIR__ . '/pokemon-legacy.json'));
$dataExport = JsonEncoder::decode(file_get_contents(__DIR__ . '/livingdex-pokemon.json'));
$sortedForms = JsonEncoder::decode(file_get_contents(__DIR__ . '/pokemon-forms-sorting_order.json'));
$nonStorableForms = JsonEncoder::decode(file_get_contents(__DIR__ . '/pokemon-home-non-storable.json'));
$nonRegistableForms = JsonEncoder::decode(file_get_contents(__DIR__ . '/pokemon-home-non-registrable.json'));

$output = [];

$dataExportAssoc = [];

foreach ($dataExport as $pk) {
    $isFemale = preg_match('/-f$/i', $pk['slug']) !== false;
    $slug = $pk['slug'];
    $slugPlain = StrFormat::plainSlug($slug);
    if (!isset($extraData[$slug])) {
        throw new \Exception("Extra data not found for slug {$slug}");
    }
    if (isset($dataExportAssoc[$slugPlain])) {
        throw new \Exception("Data already set for slug {$slugPlain}");
    }
    $pk['showdown_slug'] = $slugPlain;
    $pk['is_female'] = $isFemale;
    $dataExportAssoc[$slugPlain] = $pk;
}

function cleanup_nulls_recursive(array $arr): array
{
    $result = [];
    foreach ($arr as $k => $v) {
        $val = $v;
        if ($val === null || $val === '' || $val === []) {
            continue;
        }
        if (is_array($val)) {
            $val = cleanup_nulls_recursive($val);
        }
        $result[$k] = $val;
    }

    return $result;
}

foreach ($extraData as $slug => $pkx) {
    $slugPlain = StrFormat::plainSlug($slug);
    if (!isset($dataExportAssoc[$slugPlain])) {
        throw new \Exception("Data export data not found for slug {$slugPlain}");
    }
    if (isset($output[$slugPlain])) {
        throw new \Exception("Data already set for slug {$slugPlain}");
    }
    $pk = $dataExportAssoc[$slugPlain];
    $formNameParts = explode('(', $pk['title'], 2);
    $formName = isset($formNameParts[1]) ? trim($formNameParts[1], '()') : null;

    if ($formName === null) {
        $formName = $showdownDex[$slugPlain]['baseForme'] ?? null;
    }

    $output[$slugPlain] = [
        'name' => $pk['title'],
        'slug' => $pk['slug'],
        'slug_plain' => $pk['showdown_slug'],
        'gen' => $pk['gen'],
        'img' => [
            'home' => $pk['imgHome'],
            'menu' => $pk['imgSprite']
        ],
        'form' => [
            'name' => $formName,
            'slug' => $formName ? StrFormat::slug($formName) : null,
            'slug_plain' => $formName ? StrFormat::plainSlug($formName) : null,
            'is_form' => $pkx['base_species'] !== null,
            'is_base_species' => $pkx['base_species'] === null,
            'base_species' => $pkx['base_species'],
            'base_data_form' => $pkx['base_data_form'],
            'changes_from' => $pkx['changes_from'],
            'has_gender_diffs' => $pkx['has_gender_diffs'],
            'can_dynamax' => $pkx['can_dynamax'],
            'is_gigantamax' => $pk['isGmax'],
            'is_battle_only' => $pkx['is_battle_only'],
            'is_reversible' => $pkx['is_reversible'],
            'is_cosmetic' => $pkx['is_cosmetic'],
            'is_female' => $pk['is_female'],
            'is_fusion' => $pkx['is_fusion'],
            'fused_pokemon' => $pkx['fused_pokemon'],
        ],
        'forms_order' => $sortedForms[$slug] ?? null,
        //'flags' => [
        'is_legendary' => $pkx['is_legendary'],
        'is_mythical' => $pkx['is_mythical'],
        'is_home_storable' => !in_array($slug, $nonStorableForms, true),
        'is_home_registrable' => !in_array($slug, $nonRegistableForms, true),
        //],
        //'stats' => [
        "shape" => $pkx['shape'],
        "catch_rate" => $pkx['catch_rate'],
        "base_friendship" => $pkx['base_friendship'],
        "growth_rate" => $pkx['growth_rate'],
        "yield_base_exp" => $pkx['yield_base_exp'],
        "yield_stats" => $pkx['yield_stats'],
        "hatch_cycles" => $pkx['hatch_cycles'],
        //]
    ];

    $output[$slugPlain] = cleanup_nulls_recursive($output[$slugPlain]);
}

file_put_contents(
    __DIR__ . '/pokemon.json',
    JsonEncoder::encode($output, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE, 2, 3)
);
