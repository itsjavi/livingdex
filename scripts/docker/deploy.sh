#!/usr/bin/env zsh

echo "------ Deploying project to gh-pages ------"

cd apps/livingdex-ui
npm run deploy

echo "DEPLOYMENT FINISHED SUCCESSFULLY."
echo "Go visit https://itsjavi.com/livingdex after some minutes."
