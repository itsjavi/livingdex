#!/usr/bin/env bash

IMG_DIR=${1}
IMG_RESIZE=${2}

echo "Resizing ${IMG_DIR} PNGs to ${IMG_RESIZE} ..."
mogrify -resize "${IMG_RESIZE}" "${IMG_DIR}"/*.png
