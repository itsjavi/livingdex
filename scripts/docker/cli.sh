#!/usr/bin/env bash

docker-compose exec --workdir=/usr/src/project/apps/data-generator phpfpm bin/console "${@}"
