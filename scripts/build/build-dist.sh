#!/usr/bin/env bash

# -------------------------
# Generate DIST data
# -------------------------
cd "${APPS_DIR}/db"

rm -rf "${DIST_DIR}"
mkdir -p "${DIST_DIR}"

CSV_DATA_DIR="${DIST_DIR}/csv"
JSON_DATA_DIR="${DIST_DIR}/json"

mkdir -p "${CSV_DATA_DIR}"
mkdir -p "${JSON_DATA_DIR}"

#bin/console app:make:livingdex --pretty >dist/data/livingdex-data.json
#bin/console app:make:livingdex >dist/data/livingdex-data.min.json

# TODO export all tables to CSV to keep data changes under source control
function table_export_csv() {
  bin/console app:data:export -vvv --format=csv "SELECT * FROM ${1} ORDER BY id" >"${CSV_DATA_DIR}/${1}.csv"
}

table_export_csv game_group
table_export_csv game
table_export_csv ability
table_export_csv pokemon
table_export_csv pokemon_data

bin/console app:data:export-full -vvv "${JSON_DATA_DIR}"
