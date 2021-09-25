#!/usr/bin/env bash

# Install dependencies
cd apps/ui
npm update && npm upgrade
cd -

cd apps/data-generator
composer update
cd -
#---

# Download data sources
./scripts/dependencies/showdown-data.sh update
./scripts/dependencies/veekun-pokedex.sh update
./scripts/dependencies/pogo-data.sh update

# Download assets
./scripts/dependencies/livingdex-renders.sh # update # HOME renders don't change very often, update them manually when needed
./scripts/dependencies/msikma-pokesprite.sh update
