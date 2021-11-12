#!/usr/bin/env zsh

echo "------ Building and starting containers ------"
docker-compose build
docker-compose up -d

echo "------ Installing dependencies ------"
docker-compose run --rm ui-dev npm install
docker-compose run --rm data-generator composer install

echo "------ Installing assets ------"
./scripts/install-assets/showdown-data.sh
./scripts/install-assets/veekun-pokedex.sh
./scripts/install-assets/livingdex-renders.sh
./scripts/install-assets/msikma-pokesprite.sh
