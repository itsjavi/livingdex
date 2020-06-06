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
  IMG_NEW_RELATIVE_SIZE="15%"

  cp -R ./vendor/itsjavi/pokemon-media/pokemon/renders/ ./static/media/renders
  for f in $(find "./static/media/renders" -name "*.png"); do
    echo "${f}"
    magick mogrify -resize ${IMG_NEW_RELATIVE_SIZE} "${f}"
  done
fi

if [[ ! -d "static/media/symbols" ]]; then
  cp -R ./vendor/itsjavi/pokemon-media/symbols/ ./static/media/symbols
fi
