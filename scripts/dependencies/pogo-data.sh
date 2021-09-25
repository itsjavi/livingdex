#!/usr/bin/env bash

if [[ -z "${SOURCES_DIR}" ]]; then
  echo "SOURCES_DIR env var not set"
  exit 1
fi

mkdir -p "${SOURCES_DIR}"
POGO_DIR="${SOURCES_DIR}/pogo-data"

if [[ ! -d "./${POGO_DIR}" || "${1}" == "update" ]]; then
  rm -rf "${POGO_DIR}"
  mkdir -p "${POGO_DIR}"
  
  echo "Dumping PoGO data to JSON..."

  python3 /usr/src/pogo-dumper/pogo-dumper/dumper.py moves > "${POGO_DIR}"/pogo-moves.json
  python3 /usr/src/pogo-dumper/pogo-dumper/dumper.py pokemon > "${POGO_DIR}"/pogo-pokemon.json
fi

echo "pogo-data is up to date."
