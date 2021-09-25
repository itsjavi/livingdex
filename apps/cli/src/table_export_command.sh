table=${args[table]}
format=${args[--format]}

"${APPS_DIR}/db/bin/console" app:data:export -vvv --format="${format}" "SELECT * FROM ${table} ORDER BY id"
