default:
	cd apps/cli && make
	./livingdex start
	@if [ ! -d ".sources/veekun-pokedex" ]; then\
		./livingdex install;\
	fi
	./livingdex build
