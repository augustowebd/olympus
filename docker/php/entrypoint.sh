#!/bin/sh
set -e

if [ ! -f vendor/autoload.php ]; then
    composer install --no-interaction --prefer-dist
fi

if [ ! -f .env ]; then
    cp .env.example .env
fi

php artisan key:generate --ansi --force
php artisan migrate --force

if [ "$#" -gt 0 ]; then
    exec "$@"
fi

exec php artisan serve --host=0.0.0.0 --port=8000
