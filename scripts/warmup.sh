#!/usr/bin/env bash

cd apps/datanorm
composer dumpautoload
bin/console cache:clear
