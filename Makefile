default: build

start:
	docker-compose up -d

build:
	docker-compose run --rm frontend ./build.sh

install:
	docker-compose run --rm frontend npm install

publish:deploy
deploy:
	npm run deploy
