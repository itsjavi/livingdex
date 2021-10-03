#!/usr/bin/env bash

CSV_DATA_DIR="${DIST_DIR}/csv"
JSON_DATA_DIR="${DIST_DIR}/json"

cd "${APP_DIR}"

function table_export_csv() {
  bin/console app:data:export -vvv --format=csv "SELECT * FROM ${1} ORDER BY id" > "${CSV_DATA_DIR}/${1}.csv" || exit 1
}

function table_export_csv_all() {
  # TODO export all tables to CSV to keep data changes under source control
  table_export_csv game_group
  table_export_csv game
  table_export_csv ability
  table_export_csv pokemon
  table_export_csv pokemon_data
}

function table_export_json_all() {
  bin/console app:data:export-full -vvv "${JSON_DATA_DIR}" || exit 1
}

table_export_csv_all
table_export_json_all
node scripts/build-ui-pokemon-index.mjs || exit 1
