<?php

use App\Support\Serialization\Encoder\JsonEncoder;

require __DIR__ . '/../../../vendor/autoload.php';

/*
 * Quick maintenance tool for src/DataSources/Data/extras/pokemon.json
 * To append a new entry at the end.
 */

$file = __DIR__ . '/../../DataSources/Data/extras/pokemon.json';
$json = file_get_contents($file);

$newSlugs = $argv[1] ?? null;

if ($newSlugs === null) {
    echo "First argument should be the new Pokemon slug name (or many separated by comma or whitespace), but is empty.";
    exit(1);
}

$newSlugs = str_replace([PHP_EOL, ' '], ',', $newSlugs);

function nullify_array(array $arr): array
{
    foreach ($arr as $k => $val) {
        if (is_int($val) || is_float($val)) {
            $arr[$k] = -1;
            continue;
        }
        if (is_string($val)) {
            $arr[$k] = '?';
            continue;
        }
        if (is_bool($val)) {
            $arr[$k] = false;
            continue;
        }
        $arr[$k] = is_array($val) ? nullify_array($val) : null;
    }

    return $arr;
}

$data = JsonEncoder::decode($json);
$template = nullify_array(current($data));

$newSlugs = explode(',', $newSlugs);
foreach ($newSlugs as $slug) {
    if (empty($slug)) {
        throw new \Exception("The slug cannot be empty");
    }
    if (isset($data[$slug])) {
        throw new \Exception("The slug is already set: {$slug}");
    }
    $data[$slug] = $template;
}

file_put_contents($file, JsonEncoder::encodePrettyCompact($data));
