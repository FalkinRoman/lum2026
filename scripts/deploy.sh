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

echo "Building production image..."
docker compose --profile production build web

echo "Starting production container..."
docker compose --profile production up -d web

echo "Done."
docker compose --profile production ps
echo "Site: $(grep '^APP_URL=' .env | cut -d= -f2-) (container port ${WEB_PORT:-8080})"
