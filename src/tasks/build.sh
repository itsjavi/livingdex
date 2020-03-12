#!/usr/bin/env zsh

rm -f static/data/pokemon-boxes.json
./src/tasks/install.sh
gatsby clean
gatsby build

