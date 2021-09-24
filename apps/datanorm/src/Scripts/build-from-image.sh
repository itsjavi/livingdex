#!/usr/bin/env bash

rm -rf ./dist/csv ./src/DataSources/Data/pogo

docker container rm -f livingdex-data-dist

docker build -t livingdex-data:latest --target=builder-with-source . || exit 1
docker run --name livingdex-data-dist livingdex-data:latest || exit 1

docker cp livingdex-data-dist:/usr/src/app/dist/csv ./dist/csv
docker cp livingdex-data-dist:/usr/src/app/src/DataSources/Data/pogo ./src/DataSources/Data/pogo

docker container rm -f livingdex-data-dist || exit 1

