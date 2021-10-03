#!/usr/bin/env bash

BUILD_DIR=/usr/src/app/build
OUTPUT_DIR=${BUILD_DIR}/output

mkdir -p ${OUTPUT_DIR}/home-renders/regular
mkdir -p ${OUTPUT_DIR}/home-renders/shiny

mkdir -p ${OUTPUT_DIR}/menu-icons/regular
mkdir -p ${OUTPUT_DIR}/menu-icons/shiny

# Copy missing sources
if [[ ! -d ${BUILD_DIR}/home-renders/regular ]]; then
  rm -rf ${BUILD_DIR}/home-renders
  echo "Copying home-renders..."
  cp -R "${HOME_IMG_DIR}" ${BUILD_DIR}/home-renders
fi
if [[ ! -d ${BUILD_DIR}/menu-icons/regular ]]; then
  rm -rf ${BUILD_DIR}/menu-icons
  echo "Copying all menu-icons..."
  cp -R "${POKESPRITE_IMG_DIR}" ${BUILD_DIR}/menu-icons
fi
if [[ ! -f "${BUILD_DIR}/menu-icons/regular/egg.png" ]]; then
  echo "Copying misc menu-icons..."
  cp ${BUILD_DIR}/menu-icons/*.png "${BUILD_DIR}/menu-icons/regular"
  cp ${BUILD_DIR}/menu-icons/*.png "${BUILD_DIR}/menu-icons/shiny"
fi

