# Install dependencies
cd "${UI_APP_DIR}"
npm update && npm upgrade
cd -

cd "${DATAGEN_APP_DIR}"
composer update
cd -
#---

# Download data sources
${APPS_DIR}/cli/src/deps/showdown-data.sh update
${APPS_DIR}/cli/src/deps/veekun-pokedex.sh update
${APPS_DIR}/cli/src/deps/pogo-data.sh update

# Download assets
${APPS_DIR}/cli/src/deps/livingdex-renders.sh # update # HOME renders don't change very often, update them manually when needed
${APPS_DIR}/cli/src/deps/msikma-pokesprite.sh update
