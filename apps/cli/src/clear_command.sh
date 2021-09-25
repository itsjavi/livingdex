cleardb=${args[--db]}

cd "${APPS_DIR}/ui"

rm -rf "${APPS_DIR}/db/var/data/*"
rm -rf "${APPS_DIR}/db/var/log/*"

rm -rf "${APPS_DIR}/ui/build/*"
rm -rf "${APPS_DIR}/ui/public/assets/data/*"

cd "${APPS_DIR}/db"
composer dumpautoload
bin/console cache:clear

if [[ "${cleardb}" == "1" ]]; then
  echo "Recreating DB schema..."
  bin/console doctrine:schema:drop -f -n -q
  bin/console doctrine:schema:create -q
fi
