#!/usr/bin/env bash

docker-compose up -d
composer install

export APP_ENV=DEV
./vendor/bin/doctrine-migrations migrations:migrate --configuration=./migrations.yml --no-interaction

php -S localhost:8000 ./dev_server.php


