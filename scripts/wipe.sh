#!/usr/bin/env bash

rm -rf apps/datanorm/var/data/*
rm -rf apps/datanorm/var/log/*
rm -rf apps/ui/build/*
rm -rf assets/dist/*
rm -rf data/dist/*


cd apps/datanorm
composer dumpautoload
bin/console cache:clear

echo "Recreating DB schema..."
bin/console doctrine:schema:drop -f -n -q
bin/console doctrine:schema:create -q
cd -
