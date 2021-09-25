#!/usr/bin/env bash

docker-compose exec --workdir=/usr/src/project/apps/db phpfpm bin/console "${@}"
