#!/bin/sh
set -e

cd /var/www/html

if [ ! -f .env ]; then
    if [ -f .env.example ]; then
        cp .env.example .env
    fi
fi

DB_FILE="${DB_DATABASE:-database/database.sqlite}"
mkdir -p "$(dirname "$DB_FILE")"
if [ ! -f "$DB_FILE" ]; then
    touch "$DB_FILE"
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

# Livewire temporary uploads (must be on the writable storage volume).
mkdir -p storage/app/livewire-tmp storage/app/private/livewire-tmp storage/app/public storage/app/backups storage/app/lum-writable

# Filament disk `lum` points at public/images/lum (baked into the image).
# Persist writable upload dirs on the storage volume so www-data can write
# and files survive image rebuilds, without hiding stock assets forever.
persist_lum_dir() {
    name="$1"
    target="public/images/lum/${name}"
    persist="storage/app/lum-writable/${name}"

    mkdir -p "${persist}"

    if [ -L "${target}" ]; then
        return 0
    fi

    if [ -d "${target}" ]; then
        cp -a "${target}/." "${persist}/" 2>/dev/null || true
        rm -rf "${target}"
    fi

    ln -sfn "/var/www/html/storage/app/lum-writable/${name}" "${target}"
}

mkdir -p public/images/lum storage/app/lum-writable storage/app/backups storage/logs storage/app/private/livewire-tmp
touch storage/logs/laravel.log
for dir in avatars uploads menu hero shop villas interior location polaroids stay dining relax discover blog activity excursion restaurant villa; do
    persist_lum_dir "${dir}"
done

# SQLite: faster concurrent reads/writes for admin uploads + CMS.
if [ "${DB_CONNECTION:-sqlite}" = "sqlite" ] && [ -f "$DB_FILE" ]; then
    sqlite3 "$DB_FILE" "PRAGMA journal_mode=WAL; PRAGMA synchronous=NORMAL;" >/dev/null 2>&1 || true
fi

if [ "$APP_ENV" = "production" ]; then
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    php artisan event:cache 2>/dev/null || true
fi

chmod -R 775 storage bootstrap/cache database public/images/lum 2>/dev/null || true

if [ "$(id -u)" = "0" ] && id www-data >/dev/null 2>&1; then
    chown -R www-data:www-data storage bootstrap/cache database public/images/lum 2>/dev/null || true
fi

exec "$@"
