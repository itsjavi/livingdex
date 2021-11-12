#!/usr/bin/env bash

REPO="msikma-pokesprite"
REPO_FQN="msikma/pokesprite"
SOURCES_DIR="./.sources"

mkdir -p "${SOURCES_DIR}"
cd "${SOURCES_DIR}"

if [[ ! -d "./${REPO}" ]]; then
  git clone https://github.com/${REPO_FQN}.git "${REPO}"
fi

cd "${REPO}"

if [[ "${1}" == "update" ]]; then
  git pull
fi

echo "${REPO} is up to date."
