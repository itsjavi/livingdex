CSV_DATA_DIR="${DIST_DIR}/csv"
JSON_DATA_DIR="${DIST_DIR}/json"

function livingdex_cleanup() {
  rm -rf "${DIST_DIR}"
  mkdir -p "${CSV_DATA_DIR}"
  mkdir -p "${JSON_DATA_DIR}"
}

function table_export_csv() {
  ${CLI_APP} table-export --format=csv "${1}" >"${CSV_DATA_DIR}/${1}.csv"
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
  node "${APPS_DIR}/cli/src/build-ui-pokemon-index.mjs"
}

function ui_generate_thumbnails() {
  THUMBS_DIR="${UI_ASSETS_DIR}/images/home"

  if [[ ! -d "${THUMBS_DIR}" ]]; then
    echo "Adding image assets and generating thumbnails..."

    HOME_RENDERS_THUMBNAIL_RESIZE=${HOME_RENDERS_THUMBNAIL_RESIZE:-"25%"}

    rm -rf ${THUMBS_DIR} && mkdir -p ${THUMBS_DIR}

    echo "Copying original Pokemon renders to ${THUMBS_DIR} ..."

    cp -nR "${SOURCES_DIR}/livingdex-renders/images/home/pokemon/" ${THUMBS_DIR}
    PNG_FILES=$(find "${THUMBS_DIR}" -name "*.png")

    echo "Resizing Pokemon renders to ${HOME_RENDERS_THUMBNAIL_RESIZE} of size (may take up to 5 min) ..."

    for f in ${PNG_FILES}; do
      mogrify -resize "${HOME_RENDERS_THUMBNAIL_RESIZE}" "${f}"
    done

    echo "Thumbnails created successfully."
  fi
}

function livingdex_build() {
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
