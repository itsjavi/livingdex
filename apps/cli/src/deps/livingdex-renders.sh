#!/usr/bin/env bash

REPO="livingdex-renders"
# REPO_FQN="itsjavi/${REPO}"

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
    ${CLI_APP} megadl "${HOME_RENDERS_DOWNLOAD_URL}" "${REPO}.zip"
  fi
  unzip "${REPO}.zip"
fi

echo "${REPO} is up to date."
