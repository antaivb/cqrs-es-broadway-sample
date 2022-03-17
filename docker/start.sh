#!/usr/bin/env bash

set -e
set -x

while ! mysqladmin ping -h${DB_HOST} --silent; do
	echo "MYSQL NOT READY"
    sleep 1
done
echo "MYSQL READY"

if [[ ${XDEBUG_ENABLED:-"false"} == "true" ]] ; then
    echo "WARNING: XDEBUG LOADED!"
    echo "         xdebug being loaded on production even if its not enabled at all degrades performance!!"
    docker-php-ext-enable xdebug
else
    echo "NOTE: You can enable manually xdebug by running 'docker-php-ext-enable xdebug'"
    echo "      and signaling apache with 'kill -SIGUSR1 <apache_pid>' to refresh the process."
    echo "      Also, you can start the container with XDEBUG_ENABLED=true to start it automatically"
fi

curl -sS https://getcomposer.org/installer | php -- --filename=composer.phar

composer install -vvv
symfony server:start
