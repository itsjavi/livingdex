#!/usr/bin/env zsh

cd vendor/route1rodent/pokemon-data
git pull
cd -

rm -f static/data/pokemon-boxes.json
php ./src/tasks/generate-livingdex-json.php >static/data/pokemon-boxes.json
