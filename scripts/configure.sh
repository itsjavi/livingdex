#!/usr/bin/env zsh

# Install ui dependencies
cd apps/ui
npm install
cd -
#---

# Install data-normalizer dependencies
cd apps/data-normalizer
composer install
cd -
#---

# Download Data sources
mkdir -p data/sources
cd data/sources
if [[ ! -d "./veekun-pokedex" ]]; then
  git clone https://github.com/itsjavi/veekun-pokedex.git
fi
if [[ ! -d "./showdown-data" ]]; then
  git clone https://github.com/itsjavi/showdown-data.git
fi
if [[ ! -d "./pogo-data" ]]; then
  echo "" # TODO
fi

cd -
#---

# Download Assets
mkdir -p assets/img
cd assets/img

if [[ ! -d "./livingdex-renders" ]]; then
  git clone git@github.com:itsjavi/livingdex-renders.git
  cd livingdex-renders
  git lfs pull
  cd -
fi

if [[ ! -d "./msikma-pokesprite" ]]; then
  git clone https://github.com/msikma/pokesprite.git msikma-pokesprite
fi

cd -
#---


