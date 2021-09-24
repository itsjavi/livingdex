#!/usr/bin/env bash

# Rebuild containers
docker-compose down
docker-compose build
docker-compose up -d
