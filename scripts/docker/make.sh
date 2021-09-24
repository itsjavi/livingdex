#!/usr/bin/env bash

args="${@}"

docker-compose run --rm --entrypoint=/bin/sh phpfpm -c "make ${args}"
