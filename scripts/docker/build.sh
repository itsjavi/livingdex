#!/usr/bin/env zsh

# cd apps/cli && make # regenerate livingdex cli first. it requires bashly.
if [ ! -f "./apps/data-generator/var/data/veekun-pokedex.sqlite" ]; then
  make install;
else
  echo "------ Building and starting containers ------"
  docker-compose build;
  docker-compose up -d;
fi

echo "------ Building project ------"
docker-compose run --rm pogo-dumper make
docker-compose run --rm data-generator make
docker-compose run --rm spritesheet-generator make
docker-compose run --rm ui-dev make
echo "BUILD FINISHED SUCCESSFULLY"
