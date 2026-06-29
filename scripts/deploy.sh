#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$ROOT_DIR"

if ! command -v docker >/dev/null 2>&1; then
    echo "docker is not installed" >&2
    exit 1
fi

if [ ! -f .env ]; then
    if [ -f .env.production.example ]; then
        cp .env.production.example .env
        echo "Created .env from .env.production.example — set APP_URL and APP_KEY before going live."
    else
        echo "Missing .env — copy .env.production.example to .env first." >&2
        exit 1
    fi
fi

if ! grep -q '^APP_KEY=base64:' .env 2>/dev/null; then
    echo "Generating APP_KEY..."
    APP_KEY="base64:$(openssl rand -base64 32)"

    if grep -q '^APP_KEY=' .env; then
        sed -i.bak "s|^APP_KEY=.*|APP_KEY=${APP_KEY}|" .env
        rm -f .env.bak
    else
        echo "APP_KEY=${APP_KEY}" >> .env
    fi
fi

# APP_URL must include WEB_PORT when not using host nginx on :80
WEB_PORT="$(grep -E '^WEB_PORT=' .env 2>/dev/null | cut -d= -f2- | tr -d ' "' || true)"
WEB_PORT="${WEB_PORT:-8080}"
APP_HOST="$(grep -E '^APP_HOST=' .env 2>/dev/null | cut -d= -f2- | tr -d ' "' || true)"
APP_HOST="${APP_HOST:-94.103.2.95}"

if grep -q '^APP_HOST=' .env; then
    sed -i.bak "s|^APP_HOST=.*|APP_HOST=${APP_HOST}|" .env
else
    echo "APP_HOST=${APP_HOST}" >> .env
fi

if grep -q '^APP_SCHEME=' .env; then
    sed -i.bak "s|^APP_SCHEME=.*|APP_SCHEME=http|" .env
else
    echo "APP_SCHEME=http" >> .env
fi

if grep -q '^APP_PORT=' .env; then
    sed -i.bak "s|^APP_PORT=.*|APP_PORT=${WEB_PORT}|" .env
else
    echo "APP_PORT=${WEB_PORT}" >> .env
fi

rm -f .env.bak

echo "Using APP_URL=http://${APP_HOST}:${WEB_PORT}"

echo "Building production image..."
docker compose --profile production build web

echo "Starting production container..."
docker compose --profile production up -d web

echo "Done."
docker compose --profile production ps
echo "Site: http://${APP_HOST}:${WEB_PORT} (container port ${WEB_PORT})"
