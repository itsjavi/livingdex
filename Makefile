default:build-all

install:
	echo "Installing npm dependencies..."
	npm install
docker-install:
	docker-compose run --rm app install

update:
	echo "Updating npm dependencies..."
	npm update
docker-update:
	docker-compose run --rm app update

build:
	echo "Building app..."
	npm run build
docker-build:
	docker-compose run --rm app build

images:
	./src/scripts/generate-images.sh || exit 1
docker-images:
	docker-compose run --rm app images

data:
	./src/scripts/generate-data.sh
	node ./src/scripts/generate-pokemon-index.mjs
docker-data: data

assets: data images
docker-assets: data docker-images

build-all: build assets
docker-build-all: docker-build docker-assets

start:
	npm start
docker-start:
	docker-compose up -d

test:
	npm test
docker-test:
	docker-compose run --rm app test

build-serve:
	cd build && open http://localhost:8000 && python3 -m http.server 8000

deploy:
	rm -rf public/assets/data/csv public/assets/data/pogo
	npm run deploy
docker-deploy:
	docker-compose run --rm app deploy