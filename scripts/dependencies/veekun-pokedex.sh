#!/usr/bin/env bash

REPO="veekun-pokedex"
REPO_FQN="itsjavi/${REPO}"
SQLITE_FILE="${DATA_DIR}/sources/pokedex.sqlite"
SQLITE_FILE_ZIP="${REPO}/pokedex/data/pokedex.sqlite.zip"
SQLITE_FILE_DEST="${APPS_DIR}/datanorm/var/data/veekun-pokedex.sqlite"

mkdir -p data/sources
cd data/sources

if [[ ! -d "./${REPO}" ]]; then
  git clone https://github.com/${REPO_FQN}.git "${REPO}"
fi

cd "${REPO}"

if [[ "${1}" == "update" ]]; then
  rm -f "${SQLITE_FILE}" "${SQLITE_FILE_DEST}"
  git pull
fi

cd -

if [[ ! -f "${SQLITE_FILE_DEST}" ]]; then
  if [[ ! -f "${SQLITE_FILE_ZIP}" ]]; then
    ${REPO}/scripts/generate-db-zip.sh
  fi
  if [[ ! -f "${SQLITE_FILE}" ]]; then
    pwd
    ls -la
    unzip "${SQLITE_FILE_ZIP}" || exit 1
  fi
  mv "${SQLITE_FILE}" "${SQLITE_FILE_DEST}"
fi
