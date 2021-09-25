#!/usr/bin/env bash

REPO="livingdex-renders"
# REPO_FQN="itsjavi/${REPO}"

mkdir -p assets/sources
cd assets/sources

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
    "${SCRIPTS_DIR}/mega-dl.sh" -o "${REPO}.zip" "${HOME_RENDERS_DOWNLOAD_URL}"
  fi
  unzip "${REPO}.zip"
fi

echo "${REPO} is up to date."
