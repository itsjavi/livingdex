#!/usr/bin/env bash

REPO="veekun-pokedex"
REPO_FQN="itsjavi/${REPO}"

mkdir -p data/sources
cd data/sources

if [[ ! -d "./${REPO}" ]]; then
  git clone https://github.com/${REPO_FQN}.git "${REPO}"
fi

cd "${REPO}"

if [[ "${1}" == "update" ]]; then
  git pull
fi
