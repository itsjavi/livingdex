#!/usr/bin/env bash

HOME_RENDERS_THUMBNAIL_RESIZE=${HOME_RENDERS_THUMBNAIL_RESIZE:-"25%"}
DEST_DIR="${UI_ASSETS_DIR}/images/home"

rm -rf ${DEST_DIR}
mkdir -p ${DEST_DIR}

echo "Copying original Pokemon renders to ${DEST_DIR} ..."

cp -nR "${SOURCES_DIR}/livingdex-renders/images/home/pokemon/" ${DEST_DIR} || exit 1
PNG_FILES=$(find "${DEST_DIR}" -name "*.png")

echo "Resizing Pokemon renders to ${HOME_RENDERS_THUMBNAIL_RESIZE} of size (may take up to 5 min) ..."
# echo $(date) >"${DEST_DIR}/mogrify.log"

for f in ${PNG_FILES}; do
  # echo "${f}" >>"${DEST_DIR}/mogrify.log"
  mogrify -resize "${HOME_RENDERS_THUMBNAIL_RESIZE}" "${f}" || exit 1
done

# find public/img/home-renders -name '*.png' -exec mogrify -resize 128x128\> {} \;

# mogrify -resize "${HOME_RENDERS_THUMBNAIL_RESIZE}" -quality 100 -path ${DEST_DIR} ${PNG_FILES} || exit 1
echo "Thumbnails created successfully."
