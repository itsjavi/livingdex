<?php

use App\Support\Serialization\Encoder\JsonEncoder;

require __DIR__ . '/../../../vendor/autoload.php';

/*
 * Quick maintenance tool for src/DataSources/Data/extras/pokemon.json
 * To add, update or delete a field in all objects at once.
 */

$file = __DIR__ . '/../../DataSources/Data/extras/pokemon.json';
$json = file_get_contents($file);

$field = $argv[1] ?? null;
$val = $argv[2] ?? null;

if ($field === null) {
    echo "First argument should be the new field name, but is empty.";
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

foreach ($data as $k => $item) {
//    if ($data[$k]['is_cosmetic'] === true && isset($data[$k]['base_species'])) {
//        $data[$k]['base_data_form'] = $data[$k]['base_species'];
//    }
//    continue;
    if (is_string($val) && (strtoupper($val) === '--REMOVE')) {
        if (array_key_exists($field, $data[$k])) {
            unset($data[$k][$field]);
        }
    } else {
        $data[$k][$field] = $val;
    }
}

$json = JsonEncoder::encodePrettyCompact($data);
file_put_contents($file, $json);
