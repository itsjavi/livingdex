#!/usr/bin/env bash

rm -rf dist/*
mkdir -p dist/csv
mkdir -p dist/json

#bin/console app:make:livingdex --pretty >dist/data/livingdex-data.json
#bin/console app:make:livingdex >dist/data/livingdex-data.min.json

# TODO export all tables to CSV to keep data changes under source control
function table_export_csv() {
  bin/console app:data:export -vvv --format=csv "SELECT * FROM ${1} ORDER BY id" >"dist/csv/${1}.csv"
}

table_export_csv game_group
table_export_csv game
table_export_csv ability
table_export_csv pokemon
table_export_csv pokemon_data

bin/console app:data:export-full -vvv "dist/json"
