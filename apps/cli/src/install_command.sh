# Install dependencies
cd "${APPS_DIR}/ui"
npm install
cd -

cd "${APPS_DIR}/db"
composer install
cd -
#---

# Download data sources
${APPS_DIR}/cli/src/deps/showdown-data.sh
${APPS_DIR}/cli/src/deps/veekun-pokedex.sh

# Download assets
${APPS_DIR}/cli/src/deps/livingdex-renders.sh
${APPS_DIR}/cli/src/deps/msikma-pokesprite.sh
