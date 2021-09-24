#!/usr/bin/env bash

# Install dependencies
cd apps/ui
npm update && npm upgrade
cd -

cd apps/datanorm
composer update
cd -
#---

# Download data sources
./scripts/dependencies/showdown-data.sh update
./scripts/dependencies/veekun-pokedex.sh update
./scripts/dependencies/pogo-data.sh update

# Download assets
./scripts/dependencies/livingdex-renders.sh update
./scripts/dependencies/msikma-pokesprite.sh update
