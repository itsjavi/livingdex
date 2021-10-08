default:
	cd apps/cli && make # regenerate livingdex cli first
	./livingdex start
	@if [ ! -f "./apps/data-generator/var/data/veekun-pokedex.sqlite" ]; then\
		./livingdex install;\
	fi
	docker-compose run --rm pogo-dumper make
	docker-compose run --rm data-generator make
	docker-compose run --rm spritesheet-generator make
	docker-compose run --rm ui-dev make

clear: # remove all generated data, except sources
	docker-compose down --remove-orphans
	docker-compose build && docker-compose up -d
	##
	rm -rf \
		dist/* \
		apps/data-generator/var/cache/* \
		apps/data-generator/var/data/* \
		apps/data-generator/var/log/* \
		apps/spritesheet-generator/build/* \
		apps/livingdex-ui/build/* \
		apps/livingdex-ui/public/assets/*
	##
	docker-compose run --rm --workdir=/usr/src/project/apps/data-generator phpfpm composer dumpautoload
	docker-compose run --rm --workdir=/usr/src/project/apps/data-generator phpfpm bin/console cache:clear

clear-sources:
	rm -rf ./.sources/*
