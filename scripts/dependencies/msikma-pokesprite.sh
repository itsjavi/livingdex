#!/usr/bin/env bash

REPO="msikma-pokesprite"
REPO_FQN="msikma/pokesprite"

mkdir -p assets/sources
cd assets/sources

if [[ ! -d "./${REPO}" ]]; then
  git clone https://github.com/${REPO_FQN}.git "${REPO}"
fi

cd "${REPO}"

if [[ "${1}" == "update" ]]; then
  git pull
fi
