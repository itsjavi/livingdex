#echo "# this file is located in 'src/query_command.sh'"
#echo "# code for 'livingdex query' goes here"
#echo "# you can edit it freely and regenerate (it will not be overwritten)"
#inspect_args

sql=${args[sql]}

"${DATAGEN_APP_DIR}/bin/console" app:data:export -vvv --format=json "${sql}"
