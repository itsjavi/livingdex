default:
	@if [ ! -d ".sources/veekun-pokedex" ]; then\
		./livingdex install;\
	fi
	./livingdex build
