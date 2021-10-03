#!/usr/bin/env bash

cd /usr/src/app

OUTPUT_DIR=/usr/src/app/build/output
SPRITESHEETS_DIR=${SPRITESHEETS_DIR:-"${OUTPUT_DIR}/spritesheets"}

HOME_RENDERS_SIZE="64x64"
MENU_ICONS_SIZE="68x56"
SPRITESHEET_GRID="32x48"
SPRITESHEET_BORDER="2"

if [[ -f "${SPRITESHEETS_DIR}/pokemon-home-regular.png" ]]; then
  echo "Sprite sheet already exists. Skipping..."
  exit
fi

mkdir -p ${SPRITESHEETS_DIR}

function resize_images() {
  ./src/resize-images.sh "${OUTPUT_DIR}/${1}" ${HOME_RENDERS_SIZE}
}

function mount_spritesheet_image() {
  ./src/mount-spritesheet-image.sh "${OUTPUT_DIR}/${1}" \
    ${SPRITESHEET_GRID} "${2}" ${SPRITESHEET_BORDER} "${3}"
}

resize_images home-renders/regular
resize_images home-renders/shiny

home_regular_file="${SPRITESHEETS_DIR}/pokemon-home-regular.png"
home_shiny_file="${SPRITESHEETS_DIR}/pokemon-home-shiny.png"
menu_regular_file="${SPRITESHEETS_DIR}/pokemon-menu-regular.png"
menu_shiny_file="${SPRITESHEETS_DIR}/pokemon-menu-shiny.png"

if [[ ! -f "${home_regular_file}" ]]; then
  mount_spritesheet_image home-renders/regular ${HOME_RENDERS_SIZE}+0+0 "${home_regular_file}"
  echo "Sharpening (1px) ${home_regular_file} ..."
  mogrify -sharpen 0x1 "${home_regular_file}"
  echo "Optimizing ${home_regular_file} ..."
  optipng "${home_regular_file}"
fi

if [[ ! -f "${home_shiny_file}" ]]; then
  mount_spritesheet_image home-renders/shiny ${HOME_RENDERS_SIZE}+0+0 "${home_shiny_file}"
  echo "Sharpening (1px) ${home_shiny_file} ..."
  mogrify -sharpen 0x1 "${home_shiny_file}"
  echo "Optimizing ${home_shiny_file} ..."
  optipng "${home_shiny_file}"
fi

if [[ ! -f "${menu_regular_file}" ]]; then
  mount_spritesheet_image menu-icons/regular ${MENU_ICONS_SIZE}+0+0 "${menu_regular_file}"
  echo "Optimizing ${menu_regular_file} ..."
  optipng "${menu_regular_file}"
fi

if [[ ! -f "${menu_shiny_file}" ]]; then
  mount_spritesheet_image menu-icons/shiny ${MENU_ICONS_SIZE}+0+0 "${menu_shiny_file}"
  echo "Optimizing ${menu_shiny_file} ..."
  optipng "${menu_shiny_file}"
fi
