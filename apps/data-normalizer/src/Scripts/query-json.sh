#!/usr/bin/env bash

bin/console app:data:export -vvv --format=json "${1}"
