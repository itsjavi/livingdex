#!/usr/bin/env bash

docker-compose exec --workdir=/usr/src/project/apps/datanorm phpfpm bin/console "${@}"
