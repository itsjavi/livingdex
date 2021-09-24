default: from-image

from-image:
	./src/Scripts/build-from-image.sh

docker-build: docker-build-pogodata
	bin/docker-exec make build

docker-db:
	bin/docker-exec make db

docker-edit-pokemon-extra-data:
	bin/docker-console app:extra-data-edit:pokemon b

docker-db-from-dist:
	bin/docker-exec make db-from-dist

docker-build-pogodata:
	docker build -t livingdex-pogodata:latest --target=pogodata-exporter .
	mkdir -p src/DataSources/Data/pogo
	docker run --rm --mount type=bind,source="$$(pwd)"/src/DataSources/Data/pogo,target=/usr/src/data livingdex-pogodata:latest

docker-install:
	bin/docker-exec composer install -v || exit 1
	bin/docker-exec make post-composer-install

docker-upgrade:
	bin/docker-exec make upgrade

upgrade:
	composer update -v
	rm -rf var/data/*.sqlite
	./src/Scripts/generate-veekun-db.sh
	make build

build: db dist
db: db-schema db-data-from-fixtures
db-from-dist: db-schema db-data-from-dist

start: up
up:
	docker-compose up -d
down:
	docker-compose down
stop:
	docker-compose stop
open:
	open http://localhost:8090/boxes
	open http://localhost:8091/?server=mysql&username=test&db=livingdex

post-composer-install:
	mkdir -p ./var/data ./dist/data ./public/img
	./src/Scripts/generate-veekun-db.sh || exit 1

update:
	composer update -v

clean:
	composer dumpautoload
	bin/console cache:clear

public-assets:
	./src/Scripts/generate-public-assets.sh

dist:
	./src/Scripts/generate-dist-data.sh

docker-dist:
	bin/docker-exec make dist

db-schema:clean
	echo "Recreating DB schema..."
	bin/console doctrine:schema:drop -f -n -q
	bin/console doctrine:schema:create -q
	# bin/console make:migration

db-data-from-fixtures:
	echo "Regenerating data from original data sources, running DB fixtures..."
	bin/console doctrine:fixtures:load -n -vvv

db-data-from-dist:
	echo "Importing data from dist/csv files (without running normalizers or DB fixtures)..."
	bin/console app:data:import -vvv # Imports the CSV files directly

#$(V).SILENT:
.PHONY: data dist docker
