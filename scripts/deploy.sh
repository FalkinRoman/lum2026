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
WEB_PORT="$(grep -E '^WEB_PORT=' .env 2>/dev/null | cut -d= -f2- | tr -d '"' || true)"
WEB_PORT="${WEB_PORT:-8080}"
APP_URL="$(grep -E '^APP_URL=' .env 2>/dev/null | cut -d= -f2- | tr -d '"' || true)"

if [ -z "$APP_URL" ]; then
    APP_URL="http://94.103.2.95:${WEB_PORT}"
elif [ "$WEB_PORT" != "80" ] && ! echo "$APP_URL" | grep -q ":${WEB_PORT}"; then
    APP_URL="${APP_URL%/}:${WEB_PORT}"
fi

APP_URL="\"${APP_URL#\"}"
APP_URL="${APP_URL%\"}"
APP_URL="\"${APP_URL}\""

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

echo "Done."
docker compose --profile production ps
echo "Site: $(grep '^APP_URL=' .env | cut -d= -f2-) (container port ${WEB_PORT:-8080})"
