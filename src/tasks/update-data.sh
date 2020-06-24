#!/usr/bin/env zsh

cd vendor/itsjavi/pokemon-data
git pull
cd -

php ./src/tasks/generate-livingdex-json.php > static/data/pokemon-boxes.json
