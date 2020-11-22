#!/usr/bin/env zsh

if [[ ! -d "node_modules" ]]; then
  npm install
fi

if [[ ! -d "vendor/itsjavi/pokemon-data" ]]; then
  git clone git@github.com:itsjavi/pokemon-data.git vendor/itsjavi/pokemon-data
fi

if [[ ! -d "vendor/itsjavi/pokemon-media" ]]; then
  git clone git@github.com:itsjavi/pokemon-media.git vendor/itsjavi/pokemon-media
fi

mkdir -p static/data
mkdir -p static/media

if [[ ! -f "static/data/pokemon-boxes.json" ]]; then
  php ./src/tasks/generate-livingdex-json.php >static/data/pokemon-boxes.json
fi

if [[ ! -d "static/media/renders" ]]; then
  ./src/tasks/make-thumbnails.sh
fi

if [[ ! -d "static/media/symbols" ]]; then
  cp -R ./vendor/itsjavi/pokemon-media/symbols/ ./static/media/symbols
fi
