#!/usr/bin/env bash

cd apps/ui

# DATA
echo "Adding data assets and generating index..."
rm -rf "${UI_ASSETS_DIR}/data"
mkdir -p "${UI_ASSETS_DIR}/data/json"
cp -R "${DATA_DIR}/dist/json" "${UI_ASSETS_DIR}/data"
node "${SCRIPTS_DIR}/build/build-ui-pokemon-index.mjs"

# THUMBNAILS (if do not exist)
if [[ ! -d "${UI_ASSETS_DIR}/images/home" ]]; then
  echo "Adding image assets and generating thumbnails..."
  "${SCRIPTS_DIR}/build/build-ui-images.sh"
fi

# Build React App
npm run build
