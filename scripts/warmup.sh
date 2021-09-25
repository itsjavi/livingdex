#!/usr/bin/env bash

cd apps/data-generator
composer dumpautoload
bin/console cache:clear
