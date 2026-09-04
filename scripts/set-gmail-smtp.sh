#!/usr/bin/env bash
# Write Gmail SMTP settings into /opt/lumresidence/.env (run ON the server).
#
# Usage:
#   APP_PASSWORD='xxxx xxxx xxxx xxxx' ./scripts/set-gmail-smtp.sh
#   # or interactive:
#   ./scripts/set-gmail-smtp.sh
#
# Then: docker compose --profile production restart web
# Optional test:
#   docker compose --profile production exec -T web php artisan tinker --execute="Mail::raw('Lum SMTP OK', fn (\$m) => \$m->to('dimacake@gmail.com')->subject('Lum SMTP test'));"

set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$ROOT_DIR"

if [ ! -f .env ]; then
    echo "Missing .env in ${ROOT_DIR}" >&2
    exit 1
fi

MAIL_USER="${MAIL_USERNAME:-dimacake@gmail.com}"
MAIL_FROM="${MAIL_FROM_ADDRESS:-$MAIL_USER}"
APP_PASSWORD="${APP_PASSWORD:-}"

if [ -z "$APP_PASSWORD" ]; then
    printf 'Вставь пароль приложения Google (16 символов): '
    read -r APP_PASSWORD
fi

# Strip spaces Google shows in the UI
APP_PASSWORD="$(printf '%s' "$APP_PASSWORD" | tr -d '[:space:]')"

if [ "${#APP_PASSWORD}" -lt 16 ]; then
    echo "Пароль приложения слишком короткий — проверь копипаст." >&2
    exit 1
fi

set_env () {
    local key="$1"
    local value="$2"
    local escaped="${value//\\/\\\\}"
    escaped="${escaped//|/\\|}"
    escaped="${escaped//&/\\&}"
    if grep -q "^${key}=" .env; then
        sed -i.bak "s|^${key}=.*|${key}=${escaped}|" .env
    else
        printf '%s=%s\n' "$key" "$value" >> .env
    fi
}

set_env MAIL_MAILER smtp
set_env MAIL_SCHEME smtp
set_env MAIL_HOST smtp.gmail.com
set_env MAIL_PORT 587
set_env MAIL_USERNAME "$MAIL_USER"
set_env MAIL_PASSWORD "$APP_PASSWORD"
set_env MAIL_FROM_ADDRESS "$MAIL_FROM"
set_env MAIL_FROM_NAME "Lum Residence"
set_env ADMIN_EMAILS "$MAIL_USER"

rm -f .env.bak

echo "Gmail SMTP записан в .env (MAIL_USERNAME=${MAIL_USER})."
echo "Дальше:"
echo "  docker compose --profile production up -d web"
echo "  docker compose --profile production exec -T web php artisan optimize:clear"
echo "  # тест письма:"
echo "  docker compose --profile production exec -T web php artisan tinker --execute=\"Mail::raw('Lum SMTP OK', fn (\\\$m) => \\\$m->to('${MAIL_USER}')->subject('Lum SMTP test'));\""
