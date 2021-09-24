#!/usr/bin/env bash

cd apps/ui

rm -rf public/assets/data/csv public/assets/data/pogo
npm run deploy
