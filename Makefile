default:build

install: # Installs and configures the project
	./scripts/install.sh

upgrade: # Upgrades the project dependencies and data sources
	./scripts/upgrade.sh

build: # Builds the project data source and apps
	./scripts/build.sh

publish: deploy
deploy: # Deploys the apps
	./scripts/deploy.sh

info:
	php -v
	php --ini
	composer --version
	node -v
	npm -v
	python --version
	pip --version
	which pip
	echo $$HOME
	echo $$PATH
	whoami

open:
	open http://localhost:8150
	open http://localhost:3151/?server=mysql&username=test&db=livingdex
	open http://localhost:8150/livingdex/

#.PHONY: build data assets
