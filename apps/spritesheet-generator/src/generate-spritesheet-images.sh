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
    ${SPRITESHEET_GRID} "${2}" ${SPRITESHEET_BORDER} "${SPRITESHEETS_DIR}/${3}"
}

resize_images home-renders/regular
resize_images home-renders/shiny

mount_spritesheet_image home-renders/regular ${HOME_RENDERS_SIZE}+0+0 pokemon-home-regular.png
mount_spritesheet_image home-renders/shiny ${HOME_RENDERS_SIZE}+0+0 pokemon-home-shiny.png

mount_spritesheet_image menu-icons/regular ${MENU_ICONS_SIZE}+0+0 pokemon-menu-regular.png
mount_spritesheet_image menu-icons/shiny ${MENU_ICONS_SIZE}+0+0 pokemon-menu-shiny.png
