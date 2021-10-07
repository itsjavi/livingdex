#!/usr/bin/env bash

REPO="veekun-pokedex"
REPO_FQN="itsjavi/${REPO}"
SQLITE_FILE="${SOURCES_DIR}/pokedex.sqlite"
SQLITE_FILE_ZIP="${REPO}/pokedex/data/pokedex.sqlite.zip"
SQLITE_FILE_DEST="${DATAGEN_APP_DIR}/var/data/veekun-pokedex.sqlite"

mkdir -p "${SOURCES_DIR}"
cd "${SOURCES_DIR}"

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

echo "${REPO} is up to date."
