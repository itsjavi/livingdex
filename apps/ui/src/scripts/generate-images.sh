#!/usr/bin/env bash

LIVINGDEX_THUMBNAIL_SIZE=${LIVINGDEX_THUMBNAIL_SIZE:-"25%"}
DEST_DIR=${LIVINGDEX_THUMBNAIL_DIR:-"./public/assets/images/home"}

rm -rf ${DEST_DIR}
mkdir -p ${DEST_DIR}

echo "Copying original Pokemon renders to ${DEST_DIR} ..."

cp -nR ./node_modules/livingdex-renders/images/home/pokemon/ ${DEST_DIR} || exit 1
PNG_FILES=$(find "${DEST_DIR}" -name "*.png")

echo "Resizing Pokemon renders to ${LIVINGDEX_THUMBNAIL_SIZE} of size (may take up to 5 min) ..."
echo $(date) >"${DEST_DIR}/mogrify.log"

for f in ${PNG_FILES}; do
  echo "${f}" >>"${DEST_DIR}/mogrify.log"
  mogrify -resize "${LIVINGDEX_THUMBNAIL_SIZE}" "${f}" || exit 1
done

# find public/img/home-renders -name '*.png' -exec mogrify -resize 128x128\> {} \;

# mogrify -resize "${LIVINGDEX_THUMBNAIL_SIZE}" -quality 100 -path ${DEST_DIR} ${PNG_FILES} || exit 1
echo "Thumbnails created successfully."
