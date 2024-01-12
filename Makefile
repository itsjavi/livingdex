default: build

start:
	npm start

build:
	./build.sh

install:
	npm install

publish:deploy
deploy:
	make build || exit 1
	npm run deploy
