#!/bin/sh
set -e

if [ ! -f vendor/autoload.php ]; then
    composer install --no-interaction --prefer-dist
fi

if [ ! -f .env ]; then
    cp .env.example .env
fi

# ponytail: php artisan serve (servidor embutido) nao repassa de forma
# confiavel as env vars do processo pai pra cada worker/requisicao — grava
# as variaveis relevantes direto no .env pra garantir que valham em runtime.
# Upgrade: trocar artisan serve por php-fpm+nginx elimina essa necessidade.
sync_env() {
    var_name="$1"
    var_value=$(eval "echo \"\$$var_name\"")

    if [ -n "$var_value" ]; then
        if grep -q "^${var_name}=" .env; then
            sed -i "s#^${var_name}=.*#${var_name}=${var_value}#" .env
        else
            echo "${var_name}=${var_value}" >> .env
        fi
    fi
}

for var in DB_CONNECTION DB_HOST DB_PORT DB_DATABASE DB_USERNAME DB_PASSWORD \
    CACHE_STORE REDIS_CLIENT REDIS_HOST REDIS_PORT REDIS_DB; do
    sync_env "$var"
done

php artisan key:generate --ansi --force
php artisan migrate --force

if [ "$#" -gt 0 ]; then
    exec "$@"
fi

exec php artisan serve --host=0.0.0.0 --port=8000
