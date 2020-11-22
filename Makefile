default:build
publish:pages

install-tools:
	./src/tasks/install-prerequisites.sh

install:
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
pages:build
	npm run publish

develop:start
start:
	./src/tasks/update-data.sh
	npm run start

$(V).SILENT:
.PHONY: build
