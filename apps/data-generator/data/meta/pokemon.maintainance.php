<?php // Maintainance script to quickly edit data.

namespace Tools;

use App\Support\Serialization\Encoder\JsonEncoder;

require __DIR__ . '/../../vendor/autoload.php';

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
    // $pokedex[$slug]['is_female'] = ($pk['form_slug'] === 'female');
    // unset($pokedex[$slug]['sorting_order']);
}

save_json($pokedex, __DIR__ . '/pokemon.json');
