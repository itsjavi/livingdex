default:
	mkdir -p "$${DATA_DIR}"
	rm -f "$${DATA_DIR}/"*.json
	python3 pogo-dumper/dumper.py pokemon > "$${DATA_DIR}/pogo-pokemon.json"
	python3 pogo-dumper/dumper.py moves > "$${DATA_DIR}/pogo-moves.json"
