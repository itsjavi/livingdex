#!/usr/bin/env zsh

IMG_NEW_RELATIVE_SIZE="25%"
rm -rf ./static/media/renders

cp -R ./vendor/itsjavi/pokemon-media/pokemon/renders/ ./static/media/renders
for f in $(find "./static/media/renders" -name "*.png"); do
  echo "${f}"
  magick mogrify -resize ${IMG_NEW_RELATIVE_SIZE} "${f}"
done
