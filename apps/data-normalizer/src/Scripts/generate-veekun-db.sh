#!/usr/bin/env bash

VEEKUN_DIR="./vendor/itsjavi/veekun-pokedex"
VEEKUN_DB_DEST=./var/data/veekun-pokedex.sqlite
VEEKUN_DB_SRC="${VEEKUN_DIR}/pokedex/data/pokedex.sqlite"
VEEKUN_DB_SRC_ZIP="${VEEKUN_DB_SRC}.zip"

if [[ ! -d "${VEEKUN_DIR}" ]]; then
  echo "Veekun DIR does not exist: ${VEEKUN_DIR}"
  exit 1
fi

echo "Creating Veekun DB in ${VEEKUN_DB_DEST}"

if [[ -f "${VEEKUN_DB_DEST}" ]]; then
  echo "Veekun SQLite DB already exists. Skipping..."
  exit 0
fi

mkdir -p ./var/data

# Generate veekun sqlite

if [[ ! -f "pokedex.sqlite" ]]; then
  if [[ ! -f "${VEEKUN_DB_SRC_ZIP}" ]]; then
    ${VEEKUN_DIR}/scripts/generate-db-zip.sh
  fi
  unzip "${VEEKUN_DB_SRC_ZIP}" || exit 1
fi

mv pokedex.sqlite "${VEEKUN_DB_DEST}" || exit 1

echo "Veekun SQLite DB created."
