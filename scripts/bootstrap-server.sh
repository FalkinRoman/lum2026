#!/usr/bin/env bash
# Fresh production bootstrap on the VPS.
# Run ON the server as lumadm from anywhere:
#   curl -fsSL ... | bash   OR   bash scripts/bootstrap-server.sh
#
# Env overrides:
#   REPO_URL=... APP_HOST=45.151.62.114 WEB_PORT=8080
#   ADMIN_NAME=Admin ADMIN_EMAIL=lumadm@mail.ru ADMIN_PASSWORD=...

set -euo pipefail

REPO_URL="${REPO_URL:-https://github.com/FalkinRoman/lum2026.git}"
APP_DIR="${APP_DIR:-/opt/lumresidence}"
APP_HOST="${APP_HOST:-45.151.62.114}"
WEB_PORT="${WEB_PORT:-8080}"
ADMIN_NAME="${ADMIN_NAME:-Admin}"
ADMIN_EMAIL="${ADMIN_EMAIL:-lumadm@mail.ru}"
ADMIN_PASSWORD="${ADMIN_PASSWORD:-}"

if ! command -v docker >/dev/null 2>&1; then
    echo "docker is required" >&2
    exit 1
fi

if ! command -v git >/dev/null 2>&1; then
    echo "git is required" >&2
    exit 1
fi

if [ ! -d "$APP_DIR/.git" ]; then
    echo "==> Cloning into ${APP_DIR}"
    sudo mkdir -p "$(dirname "$APP_DIR")"
    if [ -d "$APP_DIR" ] && [ -n "$(ls -A "$APP_DIR" 2>/dev/null || true)" ]; then
        echo "Directory ${APP_DIR} exists and is not empty — aborting clone." >&2
        exit 1
    fi
    sudo git clone "$REPO_URL" "$APP_DIR"
    sudo chown -R "$(id -u):$(id -g)" "$APP_DIR"
else
    echo "==> Updating ${APP_DIR}"
    cd "$APP_DIR"
    git fetch --all --prune
    git reset --hard origin/main
    git pull --ff-only origin main || true
fi

cd "$APP_DIR"

if [ ! -f .env ]; then
    cp .env.production.example .env
fi

# Force this host / port for the new server
if grep -q '^APP_HOST=' .env; then
    sed -i.bak "s|^APP_HOST=.*|APP_HOST=${APP_HOST}|" .env
else
    echo "APP_HOST=${APP_HOST}" >> .env
fi
if grep -q '^WEB_PORT=' .env; then
    sed -i.bak "s|^WEB_PORT=.*|WEB_PORT=${WEB_PORT}|" .env
else
    echo "WEB_PORT=${WEB_PORT}" >> .env
fi
if grep -q '^APP_PORT=' .env; then
    sed -i.bak "s|^APP_PORT=.*|APP_PORT=${WEB_PORT}|" .env
else
    echo "APP_PORT=${WEB_PORT}" >> .env
fi
if grep -q '^APP_URL=' .env; then
    sed -i.bak "s|^APP_URL=.*|APP_URL=http://${APP_HOST}:${WEB_PORT}|" .env
else
    echo "APP_URL=http://${APP_HOST}:${WEB_PORT}" >> .env
fi
rm -f .env.bak

echo "==> Deploy (build + up)"
./scripts/deploy.sh

echo "==> Wait for container"
sleep 5
docker compose --profile production ps

echo "==> Seed CMS (fresh DB)"
docker compose --profile production exec -T web php artisan db:seed --class=CmsContentSeeder --force

if [ -n "$ADMIN_PASSWORD" ]; then
    echo "==> Create Filament admin ${ADMIN_EMAIL}"
    docker compose --profile production exec -T web \
        php artisan make:filament-user \
        --name="$ADMIN_NAME" \
        --email="$ADMIN_EMAIL" \
        --password="$ADMIN_PASSWORD" \
        --panel=admin || true
else
    echo "==> Skip admin user (set ADMIN_PASSWORD to create non-interactively)"
    echo "    Or run: docker compose --profile production exec web php artisan make:filament-user"
fi

echo "==> Clear caches"
docker compose --profile production exec -T web php artisan optimize:clear || true

echo
echo "Done."
echo "Site:  http://${APP_HOST}:${WEB_PORT}"
echo "Admin: http://${APP_HOST}:${WEB_PORT}/admin"
