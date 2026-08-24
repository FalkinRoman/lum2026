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
APP_HOST="${APP_HOST:-45.151.62.114}"

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

APP_URL="http://${APP_HOST}:${WEB_PORT}"
if grep -q '^APP_URL=' .env; then
    sed -i.bak "s|^APP_URL=.*|APP_URL=${APP_URL}|" .env
else
    echo "APP_URL=${APP_URL}" >> .env
fi

rm -f .env.bak

echo "Using APP_URL=${APP_URL}"

echo "Building production image..."
docker compose --profile production build web

echo "Starting production container..."
docker compose --profile production up -d web

echo "Waiting for HTTP on :${WEB_PORT}..."
for i in $(seq 1 30); do
    code="$(curl -s -o /dev/null -w '%{http_code}' --max-time 2 "http://127.0.0.1:${WEB_PORT}/" || true)"
    if [ "$code" = "200" ] || [ "$code" = "302" ]; then
        echo "Ready (HTTP ${code}) after ${i}s"
        break
    fi
    if [ "$i" = "30" ]; then
        echo "Still not ready (last HTTP ${code:-000}). Check: docker compose --profile production logs --tail=50 web" >&2
    fi
    sleep 1
done

echo "Warming image derivatives (legacy CMS uploads)..."
docker compose --profile production exec -T web php artisan lum:optimize-images || echo "optimize-images skipped (non-fatal)"

echo "Done."
docker compose --profile production ps
echo "Site: http://${APP_HOST}:${WEB_PORT} (container port ${WEB_PORT})"
