#!/usr/bin/env bash

cd "${APPS_DIR}/ui"

rm -rf public/assets/data/csv public/assets/data/pogo
npm run deploy
