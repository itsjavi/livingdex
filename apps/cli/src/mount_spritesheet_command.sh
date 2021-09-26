
cd "${HOME_RENDERS_DIR}"

if [[ ! -d ./pokemon-edited ]]; then
  echo "Resizing PNGS to ${HOME_RENDERS_THUMBNAIL_RESIZE} ..."
  cp -R pokemon pokemon-edited
  mogrify -resize "${HOME_RENDERS_THUMBNAIL_RESIZE}" pokemon-edited/*.png
  mogrify -resize "${HOME_RENDERS_THUMBNAIL_RESIZE}" pokemon-edited/regular/*.png
  mogrify -resize "${HOME_RENDERS_THUMBNAIL_RESIZE}" pokemon-edited/shiny/*.png
fi

cd pokemon-edited

# montage regular/*.png -tile 4x2 -geometry 512x512+0+0 -background transparent pokemon-regular.png
# montage regular/00*.png -geometry 512x512+0+0 -background transparent -border 2 -bordercolor transparent pokemon-regular.png

function mount_spritesheet() {
  montage "${1}"/*.png \
    -tile 32x48 \
    -background transparent \
    -border 2 \
    -bordercolor transparent \
    -interlace line \
    "${2}"
#  montage "${1}"/*.png \
#    -tile 32x48 \
#    -background transparent \
#    "${2}"
}

if [[ ! -f "./pokemon-regular.png" ||  ! -f "./pokemon-shiny.png" ]]; then
  echo "Mounting HOME renders spritesheet PNG and CSS..."
  mount_spritesheet regular pokemon-regular.png
  mount_spritesheet shiny pokemon-shiny.png

  echo "Optimizing PNGs..."
  optipng pokemon-regular.png
  optipng pokemon-shiny.png
fi

php "${APPS_DIR}/cli/scripts/generate-spritesheet-css.php"

echo "Responsive CSS spritesheet generated."
