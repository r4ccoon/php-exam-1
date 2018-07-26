#!/usr/bin/env bash

docker-compose up -d
composer install

nohup php -S localhost:8011 ./test_server.php > php_test.log 2>&1 &
echo $! > save_pid_test.txt

export APP_ENV=TEST
./vendor/bin/doctrine-migrations migrations:migrate --configuration=./migrations.yml --no-interaction
./vendor/bin/codecept run

kill -9 `cat save_pid_test.txt`
rm save_pid_test.txt

