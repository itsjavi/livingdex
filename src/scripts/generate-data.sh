#!/usr/bin/env bash

rm -rf public/assets/data
mkdir -p public/assets/data/pogo

docker container rm -f livingdex-data-dist
docker pull docker.pkg.github.com/itsjavi/livingdex-data/livingdex-data:0.3
docker run --name livingdex-data-dist docker.pkg.github.com/itsjavi/livingdex-data/livingdex-data:0.3 || exit 1

docker cp livingdex-data-dist:/usr/src/app/dist ./public/assets/data
mv ./public/assets/data/dist/* ./public/assets/data/
rm -rf ./public/assets/data/data ./public/assets/data/dist
docker cp livingdex-data-dist:/usr/src/app/src/DataSources/Data/pogo ./public/assets/data/pogo

docker container rm -f livingdex-data-dist || exit 1

echo "Data generated successfully"
