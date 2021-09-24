#!/usr/bin/env bash

# Install dependencies
cd apps/ui
npm install
cd -

cd apps/datanorm
composer install
cd -
#---

# Download data sources
./scripts/dependencies/showdown-data.sh
./scripts/dependencies/veekun-pokedex.sh
./scripts/dependencies/pogo-data.sh

# Download assets
./scripts/dependencies/livingdex-renders.sh
./scripts/dependencies/msikma-pokesprite.sh
