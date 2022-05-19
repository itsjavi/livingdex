#!/usr/bin/env bash

RENDERS_URL="https://mega.nz/#!kwtkWLaZ!QpEZIEeOADV4_xE4rCy7G1yUJFu1CvWXL4aS_1bat48"
REPO="livingdex-renders2"
# REPO_FQN="itsjavi/${REPO}"
APPS_DIR="${PWD}/apps"
SOURCES_DIR="${PWD}/.sources"

mkdir -p "${SOURCES_DIR}"
cd "${SOURCES_DIR}"

if [[ "${1}" == "update" ]]; then
  rm -rf "./${REPO}" "${REPO}.zip"
fi

if [[ ! -d "./${REPO}" ]]; then
  #  git clone git@github.com:${REPO_FQN}.git "${REPO}"
  #  cd "${REPO}"
  #  git lfs pull
  #  cd -
  if [[ ! -f "${REPO}.zip" ]]; then
    echo "Downloading ${REPO}.zip from mega.nz ..."
    ${APPS_DIR}/cli/src/lib/mega_dl.sh "${RENDERS_URL}" "${REPO}.zip"
  fi
  if [[ ! -f "${REPO}.zip" ]]; then
    echo "ZIP file not found..."
    exit 1
  fi
  unzip "${REPO}.zip"
fi

echo "${REPO} is up to date."
