default:
	cd apps/cli && make # regenerate livingdex cli first
	./livingdex start
	@if [ ! -f "./apps/db/var/data/veekun-pokedex.sqlite" ]; then\
		./livingdex install;\
	fi
	docker-compose run --rm pogo-dumper make
	docker-compose run --rm data-generator make
	docker-compose run --rm spritesheet-generator make
	docker-compose run --rm ui make

clear: # remove all generated data, except sources
	docker-compose down --remove-orphans
	docker-compose build && docker-compose up -d
	##
	rm -rf \
		dist/* \
		apps/db/var/cache/* \
		apps/db/var/data/* \
		apps/db/var/log/* \
		apps/spritesheet-generator/build/* \
		apps/ui/build/* \
		apps/ui/public/assets/*
	##
	docker-compose run --rm --workdir=/usr/src/project/apps/db phpfpm composer dumpautoload
	docker-compose run --rm --workdir=/usr/src/project/apps/db phpfpm bin/console cache:clear

clear-sources:
	rm -rf ./.sources/*
