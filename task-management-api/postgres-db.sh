#!/bin/bash
set -e

# Source the .env file to load environment variables
if [ -f .env ]; then
  echo "Loading environment variables from .env file..."
  export $(grep -v '^#' .env | xargs)
else
  echo ".env file not found!"
  exit 1
fi

# Use environment variables
DB_SERVER="${DB_DATABASE:-my_database_server}"
DB_PASSWORD="${DB_PASSWORD:-mysecretpassword}"
DB_USER="${DB_USERNAME:-my_database}"
DB_NAME="${DB_DATABASE:-my_database}"
DB_PORT="${DB_PORT:-5432}"

echo "echo stop & remove old docker [$DB_SERVER] and starting new fresh instance of [$DB_SERVER]"
(docker kill $DB_SERVER || :) && \
  (docker rm $DB_SERVER || :) && \
  docker run --name $DB_SERVER -e POSTGRES_PASSWORD=$DB_PASSWORD \
  -e PGPASSWORD=$DB_PASSWORD \
  -p $DB_PORT:$DB_PORT \
  -d postgres

# wait for pg to start
echo "sleep wait for pg-server [$DB_SERVER] to start";
SLEEP 3;

# create the db 
echo "CREATE DATABASE $DB_NAME ENCODING 'UTF-8';" | docker exec -i $DB_SERVER psql -U $DB_USER
echo "\l" | docker exec -i $DB_SERVER psql -U $DB_USER