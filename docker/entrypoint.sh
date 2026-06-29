#!/bin/sh
set -e

cd /var/www/html

if [ ! -f .env ]; then
    if [ -f .env.example ]; then
        cp .env.example .env
    fi
fi

if [ ! -f database/database.sqlite ]; then
    mkdir -p database
    touch database/database.sqlite
fi

if [ ! -f vendor/autoload.php ]; then
    if [ "$APP_ENV" = "production" ]; then
        echo "Production image is missing vendor dependencies." >&2
        exit 1
    fi

    export COMPOSER_ALLOW_SUPERUSER=1
    git config --global --add safe.directory /var/www/html

    composer install --no-interaction --prefer-source --no-progress
fi

if ! grep -q '^APP_KEY=base64:' .env 2>/dev/null; then
    php artisan key:generate --force
fi

php artisan migrate --force

if [ "$APP_ENV" = "production" ]; then
    if [ -f .env ]; then
        APP_URL_FROM_FILE=$(grep -E '^APP_URL=' .env | head -1 | cut -d= -f2- | tr -d '"' | tr -d "'")
        if [ -n "$APP_URL_FROM_FILE" ]; then
            export APP_URL="$APP_URL_FROM_FILE"
        fi
    fi

    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
fi

chmod -R 775 storage bootstrap/cache database 2>/dev/null || true

if [ "$(id -u)" = "0" ] && id www-data >/dev/null 2>&1; then
    chown -R www-data:www-data storage bootstrap/cache database 2>/dev/null || true
fi

exec "$@"
