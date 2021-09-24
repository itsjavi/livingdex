#!/usr/bin/env bash

./scripts/build/build-containers.sh
./scripts/build/build-db.sh
./scripts/build/build-dist.sh
./scripts/build/build-ui.sh
