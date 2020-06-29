default:build
publish:pages

install:
	./src/tasks/install-prerequisites.sh
	./src/tasks/install.sh
	./src/tasks/update-data.sh

data:
	./src/tasks/update-data.sh

upgrade:
	rm -rf ./static
	./src/tasks/install.sh
	./src/tasks/update-data.sh

build:
	npm run build

publish:pages
pages:
	npm run publish

develop:start
start:
	./src/tasks/update-data.sh
	npm run start

$(V).SILENT:
.PHONY: build
