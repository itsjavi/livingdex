#!/usr/bin/env bash

cd "${APPS_DIR}/ui"

rm -rf "${APPS_DIR}/db/var/data/*"
rm -rf "${APPS_DIR}/db/var/log/*"
rm -rf "${APPS_DIR}/ui/build/*"
rm -rf "${DIST_DIR}/*"
rm -rf "${UI_ASSETS_DIR}/data"


cd "${APPS_DIR}/db"
composer dumpautoload
bin/console cache:clear

echo "Recreating DB schema..."
bin/console doctrine:schema:drop -f -n -q
bin/console doctrine:schema:create -q
