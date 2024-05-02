#!/bin/bash

set -eo pipefail

if [[ ! -f ".env" ]]
then
    echo "Warning: .env not found. Coping .env from the .env.example ..."

    cp .env.example .env
fi
#convert .env into Unix format
dos2unix .env
source .env

if [[ ! -d "storage" ]]
then
    echo "Warning: no storage directory found. Creating storage directory from scratch ..."

    mkdir -p storage/app
    mkdir -p storage/framework/{cache,sessions,views}
    mkdir -p storage/logs

    touch storage/logs/laravel.log
    echo "Logs start ..." > storage/logs/laravel.log
fi

composer install --no-dev

if [[ -z "$APP_KEY" ]]
then
    echo "Warning: no app key found. Running php artisan key:generate ..."

    php artisan key:generate
fi

#if [ "$APP_ENV" == "local" ]; then
#    php artisan telescope:publish
#fi

php artisan storage:link --force

php artisan migrate --force
#php artisan permissions:refresh



chown -R nginx:nginx .

/usr/bin/supervisord -n -c /etc/supervisor/supervisord.conf



exit 0
