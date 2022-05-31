#!/usr/bin/env bash
set -e

if [[ -f ./package.json ]] && [[ ! -d ./node_modules ]]; then
  echo "Installing all dependencies (this may take a while)..."
  npm install
fi

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
  set -- npm "$@"
fi

exec "$@"

# npx create-next-app@latest --ts
