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
  cp -R vendor/route1rodent/pokemon-media/pokemon/renders/ static/media/renders
fi
