#!/usr/bin/env zsh

./src/tasks/update-gh-pages.sh || exit 1
cd gh-pages
git push