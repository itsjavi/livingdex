<?php

use App\Support\Serialization\Encoder\JsonEncoder;

require __DIR__ . '/../../../vendor/autoload.php';

/*
 * Quick maintenance tool for src/DataSources/Data/extras/pokemon.json
 * Given a pokemon slug and a field, sets the value for that entry.
 */

$file = __DIR__ . '/../../../../../data/extras/pokemon.json';
$json = file_get_contents($file);

$pkmSlug = $argv[1] ?? null;
$field = $argv[2] ?? null;
$val = $argv[3] ?? null;

if ($field === null) {
    echo "First argument should be the pokemon slug name, but it is empty.";
    exit(1);
}

if ($field === null) {
    echo "Second argument should be the new field name, but it is empty.";
    exit(1);
}

if (strtoupper($val) === 'FALSE') {
    $val = false;
} elseif (strtoupper($val) === 'TRUE') {
    $val = true;
} elseif (strtoupper($val) === 'NULL') {
    $val = null;
} elseif (preg_match('/^[{\[].*[\}\]]$/', $val)) {
    $val = JsonEncoder::decode($val);
} elseif (is_numeric($val)) {
    $val = (float)$val;
}

$data = JsonEncoder::decode($json);

if (!array_key_exists($pkmSlug, $data)) {
    echo "Pokemon entry doesn't exist: {$pkmSlug}.";
    exit(1);
}
if (!array_key_exists($field, $data[$pkmSlug])) {
    echo "Data model inconsistency: Pokemon entry field doesn't exist: {$field}. 
    Use set-field-all.php to add a new field to every Pokemon first.";
    exit(1);
}
if (is_string($val) && (strtoupper($val) === '--REMOVE')) {
    echo "Data model inconsistency: Cannot remove fields using this script. 
    Use set-field-all.php to remove a field for every Pokemon.";
    exit(1);
}

$data[$pkmSlug][$field] = $val;

$json = JsonEncoder::encodePrettyCompact($data);
file_put_contents($file, $json);
