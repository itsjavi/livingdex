#!/usr/bin/env bash

IMG_DIR=${1}
IMG_GRID_SIZE=${2}   # 32x48
IMG_TILE_SIZE=${3} # 2
IMG_TILE_BORDER=${4} # 2
IMG_DEST_FILE=${5}

if [[ -f "${IMG_DEST_FILE}" ]]; then
  echo "${IMG_DEST_FILE} already exists. Skipping montage..."
  exit
fi

echo "Mounting ${IMG_DEST_FILE} ..."
montage "${IMG_DIR}"/*.png \
  -tile "${IMG_GRID_SIZE}" \
  -geometry "${IMG_TILE_SIZE}" \
  -background transparent \
  -border "${IMG_TILE_BORDER}" \
  -bordercolor transparent \
  -interlace line \
  "${IMG_DEST_FILE}"

