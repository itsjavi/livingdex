<?php // This is just a one-off script used to migrate metadata from multiple files into one. Kept for future reusability.

namespace Tools;

use App\DataSources\Normalizer\Region\RegionEnum;
use App\Support\Serialization\Encoder\JsonEncoder;
use App\Support\Serialization\StrFormat;
use Illuminate\Support\Str;

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
    $pk['slug_plain'] = $slugPlain;
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

function save_json(array $data, string $filename)
{
    file_put_contents(
        $filename,
        JsonEncoder::encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE, 2, 3)
    );
}

$regions = [
    0 => 'unknown',
    1 => 'kanto',
    2 => 'johto',
    3 => 'hoenn',
    4 => 'sinnoh',
    5 => 'unova',
    6 => 'kalos',
    7 => 'alola',
    8 => 'galar',
    9 => 'hisui',
];

$veekunFixes = [];
$homeImages = [];
$pokespriteImages = [];

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

    $isDefault = $pkx['base_species'] === null;
    $isForm = $pkx['base_species'] !== null;

    $aliases = [];

    $speciesSlug = $pkx['base_species'] ?? $pk['slug'];
    $speciesSlugPlain = $speciesSlug ? StrFormat::plainSlug($speciesSlug) : null;
    $formSlug = $formName ? StrFormat::slug($formName) : null;

    if ($isDefault && $formSlug !== null) {
        $slugAlias = $speciesSlugPlain . '-' . $formSlug;
        if ($slug !== $slugAlias) {
            $aliases[] = $slugAlias;
        }
    }

    if ($pkx['base_data_form'] !== null && $pkx['base_data_form'] !== $pkx['base_species']) {
        echo 'Base data form different than base species: ' . $pk['slug'] . PHP_EOL;
    }

    if ($pkx['is_cosmetic'] && $pkx['base_data_form'] === null) {
        echo 'Cosmetic, but has own data: ' . $pk['slug'] . PHP_EOL;
    }

    $isMega = Str::contains($formSlug, 'mega');
    $isPrimal = Str::contains($formSlug, 'primal');
    $isTotem = Str::contains($formSlug, 'totem');
    $isGmax = Str::contains($formSlug, 'gmax');
    $isRegional = Str::contains($formSlug, RegionEnum::ALL) && ($formSlug !== 'pikachu-hoenn');

    $output[$slugPlain] = [
        'gen' => $pk['gen'],
        'region' => in_array($slug, ['meltan', 'melmetal', 'melmetal-gmax']) ? $regions[0] : $regions[$pk['gen']],
        'name' => $pk['title'],
        'form_name' => $formName,
        'slug' => $pk['slug'],
        'slug_aliases' => $aliases,
        'form_slug' => $formSlug,
        'sorting_order' => $pk['formOrder'],
        'is_cosmetic' => $pkx['is_cosmetic'],
        'has_gender_diffs' => $pkx['has_gender_diffs'],
        'is_female' => $pk['is_female'],
        'is_battle_only' => $pkx['is_battle_only'],
        'is_reversible' => $pkx['is_reversible'],
        'is_fusion' => $pkx['is_fusion'],
        'can_dynamax' => $pkx['can_dynamax'],
        'is_gmax' => $isGmax,
        'is_legendary' => $pkx['is_legendary'],
        'is_mythical' => $pkx['is_mythical'],
        'is_mega' => $isMega,
        'is_primal' => $isPrimal,
        'is_totem' => $isTotem,
        'is_regional' => $isRegional,
        'is_home_storable' => !in_array($slug, $nonStorableForms, true),
        'is_home_registrable' => !in_array($slug, $nonRegistableForms, true),
        'images' => [
            'home_render' => $pk['imgHome'],
            'box_sprite' => $pk['imgSprite']
        ],
        'is_default' => $isDefault,
        'is_form' => $isForm,
        'base_species' => $pkx['base_species'],
        'changes_from' => $pkx['changes_from'],
        'forms_order' => $sortedForms[$slug] ?? null,
        'fused_pokemon' => $pkx['fused_pokemon'],
    ];

    if ($isDefault) {
        $veekunFix = [];
        if (isset($pkx['shape']['gen-8'])) {
            $veekunFix['shape'] = $pkx['shape']['gen-8'];
        }
        if (isset($pkx['growth_rate']['gen-8'])) {
            $veekunFix['growth_rate'] = $pkx['growth_rate']['gen-8'];
        }
        if (!empty($veekunFix)) {
            $veekunFixes[$slugPlain] = $veekunFix;
        }
    }

    $homeImages[$slugPlain] = $pk['imgHome'];
    $pokespriteImages[$slugPlain] = $pk['imgSprite'];
    //$output[$slugPlain] = cleanup_nulls_recursive($output[$slugPlain]);
    $output[$slugPlain] = $output[$slugPlain];
}

//$pokemonDir = __DIR__ . '/pokemon';
//if (!is_dir($pokemonDir)) {
//    mkdir($pokemonDir, 0755, true);
//}

//$pokemonIndex = [];
//foreach ($output as $slugPlain => $pk) {
//    $pokemonIndex[$slugPlain] = [
//        'is_default' => $pk['is_default'],
//        'is_form' => $pk['is_form'],
//        'is_home_storable' => $pk['is_home_storable'],
//        'is_home_registrable' => $pk['is_home_registrable'],
//        'img_home' => $pk['img_home'],
//        'img_menu' => $pk['img_menu'],
//    ];
//}

//save_json($homeImages, __DIR__ . '/pokemon_home_renders.json');
//save_json($pokespriteImages, __DIR__ . '/pokemon_box_sprites.json');
//save_json($veekunFixes, __DIR__ . '/veekun_species.json');
save_json($output, __DIR__ . '/pokemon.json');
