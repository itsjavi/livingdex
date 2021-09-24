default:build

configure: # Installs and configures the project dependencies
	./scripts/configure.sh

upgrade: # Upgrades the project dependencies and data sources
	./scripts/upgrade.sh

build: # Builds the project data source and apps
	./scripts/build.sh

start: # Starts the apps
	./scripts/start.sh

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

.PHONY: build
