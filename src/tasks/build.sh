#!/usr/bin/env zsh

./src/tasks/update-data.sh || exit 1
gatsby clean
gatsby build

