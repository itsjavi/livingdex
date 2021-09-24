#!/usr/bin/env bash

docker-compose run --rm --entrypoint=/bin/sh make -c "${@}"
