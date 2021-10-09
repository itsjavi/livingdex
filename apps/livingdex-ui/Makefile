default:
	rm -rf build/*
	rm -rf "public/assets/data"
	mkdir -p "public/assets/data/json"
	sleep 2
	PUBLIC_URL="/livingdex" npm run build
	sleep 2 # Copy all data files after react build (faster than syncing assets folder)
	cp -R "$${DIST_DIR}/json" "public/assets/data"
	cp -R "$${DIST_DIR}/json" "build/assets/data"
	sleep 2
