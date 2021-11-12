#!/usr/bin/env zsh

echo "------ Wiping out containers, imported assets and generated data ------"

docker-compose down --remove-orphans
docker-compose build && docker-compose up -d
##
rm -rf \
  dist/* \
  apps/data-generator/var/cache/* \
  apps/data-generator/var/data/* \
  apps/data-generator/var/log/* \
  apps/spritesheet-generator/build/* \
  apps/livingdex-ui/build/* \
  apps/livingdex-ui/public/assets/*
##
sleep 2
docker-compose run --rm data-generator /bin/bash -c "composer dumpautoload && bin/console cache:clear"
