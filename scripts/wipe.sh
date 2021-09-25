#!/usr/bin/env bash

rm -rf apps/data-generator/var/data/*
rm -rf apps/data-generator/var/log/*
rm -rf apps/ui/build/*
rm -rf assets/dist/*
rm -rf data/dist/*
rm -rf "${UI_ASSETS_DIR}/data"


cd apps/data-generator
composer dumpautoload
bin/console cache:clear

echo "Recreating DB schema..."
bin/console doctrine:schema:drop -f -n -q
bin/console doctrine:schema:create -q
cd -
