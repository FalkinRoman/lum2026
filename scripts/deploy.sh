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

env_get () {
    grep -E "^${1}=" .env 2>/dev/null | cut -d= -f2- | tr -d ' "' || true
}

DOMAIN="$(env_get DOMAIN)"
WEB_PORT="$(env_get WEB_PORT)"
WEB_PORT="${WEB_PORT:-8080}"
APP_HOST="$(env_get APP_HOST)"
APP_HOST="${APP_HOST:-45.151.62.114}"
ACME_EMAIL="$(env_get ACME_EMAIL)"
ACME_EMAIL="${ACME_EMAIL:-info@lumresidence.com}"

set_env () {
    local key="$1"
    local value="$2"
    if grep -q "^${key}=" .env; then
        sed -i.bak "s|^${key}=.*|${key}=${value}|" .env
    else
        echo "${key}=${value}" >> .env
    fi
}

if [ -n "$DOMAIN" ]; then
    # Public HTTPS behind Caddy
    set_env APP_SCHEME https
    set_env APP_HOST "$DOMAIN"
    set_env APP_PORT ""
    set_env APP_URL "https://${DOMAIN}"
    set_env WEB_PORT "$WEB_PORT"
    set_env WEB_BIND 127.0.0.1
    set_env ACME_EMAIL "$ACME_EMAIL"
    set_env SESSION_SECURE_COOKIE true
    APP_URL="https://${DOMAIN}"
    WITH_CADDY=1
else
    # IP preview on :8080
    set_env APP_SCHEME http
    set_env APP_HOST "$APP_HOST"
    set_env APP_PORT "$WEB_PORT"
    set_env APP_URL "http://${APP_HOST}:${WEB_PORT}"
    set_env WEB_PORT "$WEB_PORT"
    set_env WEB_BIND 0.0.0.0
    set_env SESSION_SECURE_COOKIE false
    APP_URL="http://${APP_HOST}:${WEB_PORT}"
    WITH_CADDY=0
fi

rm -f .env.bak

# Export for compose variable substitution
set -a
# shellcheck disable=SC1091
source <(grep -E '^(DOMAIN|ACME_EMAIL|APP_SCHEME|APP_HOST|APP_PORT|APP_URL|WEB_PORT|WEB_BIND)=' .env | sed 's/\r$//')
set +a

echo "Using APP_URL=${APP_URL}"
if [ "$WITH_CADDY" = "1" ]; then
    echo "Caddy enabled for DOMAIN=${DOMAIN}"
fi

echo "Building production image..."
docker compose --profile production build web

echo "Starting production container(s)..."
if [ "$WITH_CADDY" = "1" ]; then
    docker compose --profile production up -d web caddy
else
    docker compose --profile production up -d web
    docker compose --profile production stop caddy >/dev/null 2>&1 || true
fi

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

echo "Applying migrations (map URL fix, etc.)..."
docker compose --profile production exec -T web php artisan migrate --force || echo "migrate skipped (non-fatal)"

echo "Warming image derivatives (legacy CMS uploads)..."
docker compose --profile production exec -T web php artisan lum:optimize-images || echo "optimize-images skipped (non-fatal)"

echo "Clearing Laravel caches..."
docker compose --profile production exec -T web php artisan optimize:clear || true

echo "Done."
docker compose --profile production ps
if [ "$WITH_CADDY" = "1" ]; then
    echo "Public: https://${DOMAIN} (after DNS A → this server)"
    echo "Local:  http://127.0.0.1:${WEB_PORT}"
else
    echo "Site: http://${APP_HOST}:${WEB_PORT}"
fi
