#!/usr/bin/env bash

# Install dependencies
cd "${APPS_DIR}/ui"
npm install
cd -

cd "${APPS_DIR}/db"
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
