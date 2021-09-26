CSV_DATA_DIR="${DIST_DIR}/csv"
JSON_DATA_DIR="${DIST_DIR}/json"

function dist_cleanup() {
  rm -rf "${DIST_DIR}"
  mkdir -p "${CSV_DATA_DIR}"
  mkdir -p "${JSON_DATA_DIR}"
}

function table_export_csv() {
  "${APPS_DIR}/db/bin/console" app:data:export -vvv --format=csv "SELECT * FROM ${1} ORDER BY id" > "${CSV_DATA_DIR}/${1}.csv"
}

function table_export_csv_all() {
  # TODO export all tables to CSV to keep data changes under source control
  table_export_csv game_group
  table_export_csv game
  table_export_csv ability
  table_export_csv pokemon
  table_export_csv pokemon_data
}

function table_export_json_all() {
  "${APPS_DIR}/db/bin/console" app:data:export-full -vvv "${JSON_DATA_DIR}"
}

function ui_generate_data() {
  echo "Adding data assets and generating index..."
  rm -rf "${UI_ASSETS_DIR}/data"
  mkdir -p "${UI_ASSETS_DIR}/data/json"
  cp -R "${DIST_DIR}/json" "${UI_ASSETS_DIR}/data"
  # TODO generate pokemon index from DB app and remove this mjs
  node "${APPS_DIR}/cli/scripts/build-ui-pokemon-index.mjs"
}

function ui_generate_thumbnails() {
  THUMBS_DIR="${UI_ASSETS_DIR}/images"

  if [[ ! -d "${THUMBS_DIR}" ]]; then
    mkdir -p "${THUMBS_DIR}"

    "${CLI_APP}" mount-spritesheet

    echo "Copying original Pokemon renders to ${THUMBS_DIR} ..."
    cp -nR "${HOME_RENDERS_DIR}/pokemon-edited/" "${THUMBS_DIR}/pokemon-home"
    cp -f "${RESOURCES_DIR}/img/placeholder.png" "${THUMBS_DIR}/placeholder.png"

    echo "Thumbnails created successfully."
  fi
}

function livingdex_build() {
  dist_cleanup

  # export pokemon GO data
  cd "${APPS_DIR}/pogo-dumper" && make

  # rebuild DB
  cd "${APPS_DIR}/db" && make

  # export data from DB
  table_export_csv_all
  table_export_json_all

  # copy data & assets
  ui_generate_data
  ui_generate_thumbnails

  # build UI app
  cd "${APPS_DIR}/ui" && make
}

livingdex_build
