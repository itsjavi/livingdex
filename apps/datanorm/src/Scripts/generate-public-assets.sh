#!/usr/bin/env bash

if [[ -d "public/img/home-renders" ]]; then
  echo "Assets already exist. Skipping..."
  exit 0
fi

mkdir -p public/img
cp -R src/Resources/Public/* public
cp -R vendor/msikma/pokesprite/pokemon-gen8 public/img/menu-sprites
cp -R vendor/itsjavi/livingdex-renders/images/home public/img/home-renders
find public/img/home-renders -name '*.png' -exec mogrify -resize 128x128\> {} \;
