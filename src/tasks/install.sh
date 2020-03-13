#!/usr/bin/env zsh

if [[ ! -d "node_modules" ]]; then
  npm install
fi

if [[ ! -d "vendor/route1rodent/pokemon-data" ]]; then
  git clone git@github.com:route1rodent/pokemon-data.git vendor/route1rodent/pokemon-data
fi

if [[ ! -d "vendor/route1rodent/pokemon-media" ]]; then
  git clone git@github.com:route1rodent/pokemon-media.git vendor/route1rodent/pokemon-media
fi

mkdir -p static/data
mkdir -p static/media

if [[ ! -f "static/data/pokemon-boxes.json" ]]; then
  php ./src/tasks/generate-livingdex-json.php >static/data/pokemon-boxes.json
fi

if [[ ! -d "static/media/renders" ]]; then
  IMG_NEW_RELATIVE_SIZE="15%"

  cp -R ./vendor/route1rodent/pokemon-media/pokemon/renders/ ./static/media/renders
  for f in $(find "./static/media/renders" -name "*.png"); do
    echo "${f}"
    magick mogrify -resize ${IMG_NEW_RELATIVE_SIZE} "${f}"
  done
fi

if [[ ! -d "static/media/symbols" ]]; then
  cp -R ./vendor/route1rodent/pokemon-media/symbols/ ./static/media/symbols
fi
