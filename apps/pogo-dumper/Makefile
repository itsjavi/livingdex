default:
	rm -rf "$${SOURCES_DIR}/pogo-data"
	mkdir "$${SOURCES_DIR}/pogo-data"
	python3 pogo-dumper/dumper.py pokemon > "$${SOURCES_DIR}/pogo-data/pogo-pokemon.json"
	python3 pogo-dumper/dumper.py moves > "$${SOURCES_DIR}/pogo-data/pogo-moves.json"
