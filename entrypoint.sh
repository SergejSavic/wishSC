#!/usr/bin/env bash

set -e

role=${CONTAINER_ROLE:-app}
env=${APP_ENV:-production}

if [[ "$env" != "local" ]]; then
    echo "Caching configuration..."
    php /var/www/artisan config:cache
    echo "Copying project files for shared volumes..."
    cp -R /var/www/* /app && chown -R www-data:www-data /app/storage /app/bootstrap/cache
fi

if [[ "$role" = "app" ]]; then
    php-fpm
elif [[ "$role" = "scheduler" ]]; then
    echo "Starting migrations:"

    php artisan migrate -n --force

    echo "Listen Scheduler...."
    while 'true'
    do
        php /var/www/artisan schedule:run >> /dev/null 2>&1
        sleep 60
    done
else
    echo "Could not match the container role \"$role\""
    exit 1
fi;
