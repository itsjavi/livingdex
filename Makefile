default: build

build:
	./scripts/docker/build.sh

clean-build: wipe build

install:
	./scripts/docker/install.sh

publish:deploy
deploy:
	./scripts/docker/deploy.sh

wipe:
	./scripts/docker/deploy.sh

wipe-sources:
	rm -rf ./.sources/*
