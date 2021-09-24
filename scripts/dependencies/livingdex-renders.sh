#!/usr/bin/env bash

REPO="livingdex-renders"
REPO_FQN="itsjavi/${REPO}"

mkdir -p assets/sources
cd assets/sources

if [[ ! -d "./${REPO}" ]]; then
  git clone git@github.com:${REPO_FQN}.git "${REPO}"
  cd "${REPO}"
  git lfs pull
  cd -
fi

cd "${REPO}"

if [[ "${1}" == "update" ]]; then
  git pull
fi
