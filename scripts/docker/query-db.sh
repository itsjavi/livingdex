#!/usr/bin/env bash

args="${@}"
docker-compose exec --workdir=/usr/src/project/apps/db phpfpm bin/console app:data:export -vvv --format=json "${args}"

# example:
#   ./scripts/docker/query-db.sh "SELECT * FROM game"
