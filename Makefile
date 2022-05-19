default: build

build:
	./scripts/docker/build.sh

build-ui-only:
	docker-compose run --rm ui-dev make

clean-build: wipe build

install:
	./scripts/docker/install.sh

publish:deploy
deploy:
	./scripts/docker/deploy.sh

wipe:
	./scripts/docker/wipe.sh

wipe-sources:
	rm -rf ./.sources/*
