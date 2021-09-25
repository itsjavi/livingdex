#!/usr/bin/env bash

cd "${APPS_DIR}/db"
composer dumpautoload
bin/console cache:clear
