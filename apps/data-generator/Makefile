default:
		echo "Recreating DB schema..."
		bin/console doctrine:schema:drop -f -n -q
		bin/console doctrine:schema:create -q
		# #
		echo "Regenerating data from original data sources, running DB fixtures..."
		bin/console doctrine:fixtures:load -n -vvv
		# #
		echo "Exporting data..."
		rm -rf "$${DIST_DIR}/csv" "$${DIST_DIR}/json/gen" "$${DIST_DIR}/json"/*.json
		mkdir -p "$${DIST_DIR}/csv"
		mkdir -p "$${DIST_DIR}/json"
		scripts/export-data.sh || exit 1
