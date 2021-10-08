<?php // Given a field, it makes it equal to the base_species, for the form entries

use App\Support\Serialization\Encoder\JsonEncoder;

require __DIR__ . '/../../vendor/autoload.php';
$file = __DIR__ . '/../../data/meta/pokemon.json';
$json = file_get_contents($file);
$data = JsonEncoder::decode($json);

$field = $argv[1] ?? null;
if ($field === null) {
    echo "First argument should be the field name (or comma separated list), but is empty.";
    exit(1);
}

// $fieldsEqualToSpecies = ['is_legendary', 'is_mythical', 'catch_rate', 'base_friendship', 'shape', 'growth_rate'];
$fieldsEqualToSpecies = explode(',', $field);

foreach ($data as $slug => $pkm) {
    if ($pkm['base_species'] === null) {
        continue;
    }
    foreach ($fieldsEqualToSpecies as $fieldName) {
        $data[$slug][$fieldName] = $data[$pkm['base_species']][$fieldName];
    }
}

$json = JsonEncoder::encodePrettyCompact($data);
file_put_contents($file, $json);
