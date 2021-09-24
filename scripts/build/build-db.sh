#!/usr/bin/env bash

# -------------------------
# Rebuild DB
# -------------------------
cd apps/datanorm

echo "Recreating DB schema..."
bin/console doctrine:schema:drop -f -n -q
bin/console doctrine:schema:create -q

echo "Regenerating data from original data sources, running DB fixtures..."
bin/console doctrine:fixtures:load -n -vvv
