default:
	/usr/src/app/src/prepare-build.sh
	php /usr/src/app/src/generate-sorted-files-index.php
	php /usr/src/app/src/sort-files.php
	/usr/src/app/src/generate-spritesheet-images.sh
	php /usr/src/app/src/generate-spritesheet-css.php

clear:
	rm -rf /usr/src/app/build
	rm -rf "$${SPRITESHEETS_DIR}"
