#!/usr/bin/env bash

IMG_DIR=${1}
IMG_RESIZE=${2}

if [[ -f "${IMG_DIR}/resized.log" ]]; then
  echo "${IMG_DIR} images already resized. Skipping resize..."
  exit
fi

echo "Resizing ${IMG_DIR} PNGs to ${IMG_RESIZE} ..."
mogrify -resize "${IMG_RESIZE}" "${IMG_DIR}"/*.png

echo "DONE" >"${IMG_DIR}/resized.log"
