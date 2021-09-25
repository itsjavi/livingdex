# Install dependencies
cd "${APPS_DIR}/ui"
npm update && npm upgrade
cd -

cd "${APPS_DIR}/db"
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
