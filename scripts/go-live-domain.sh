#!/usr/bin/env bash
# Switch production to a real domain behind Caddy (HTTPS / Let's Encrypt).
#
# Run ON the server as lumadm:
#   DOMAIN=lumresidence.com ACME_EMAIL=info@lumresidence.com ./scripts/go-live-domain.sh
#
# After this is running, ask DNS to point A/AAAA to this server IP.
# Caddy will issue the certificate once DNS resolves here.

set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$ROOT_DIR"

DOMAIN="${DOMAIN:-}"
ACME_EMAIL="${ACME_EMAIL:-info@lumresidence.com}"
SERVER_IP="${SERVER_IP:-45.151.62.114}"

if [ -z "$DOMAIN" ]; then
    echo "Set DOMAIN=your.domain.tld" >&2
    echo "Example: DOMAIN=lumresidence.com ACME_EMAIL=info@lumresidence.com $0" >&2
    exit 1
fi

if [ ! -f .env ]; then
    echo "Missing .env in ${ROOT_DIR}" >&2
    exit 1
fi

set_env () {
    local key="$1"
    local value="$2"
    if grep -q "^${key}=" .env; then
        sed -i.bak "s|^${key}=.*|${key}=${value}|" .env
    else
        echo "${key}=${value}" >> .env
    fi
}

set_env DOMAIN "$DOMAIN"
set_env ACME_EMAIL "$ACME_EMAIL"
set_env APP_SCHEME https
set_env APP_HOST "$DOMAIN"
set_env APP_PORT ""
set_env APP_URL "https://${DOMAIN}"
set_env SESSION_SECURE_COOKIE true
set_env SESSION_DOMAIN ".$DOMAIN"
# Keep app on localhost-only :8080; public traffic goes through Caddy :80/:443
set_env WEB_PORT 8080
set_env WEB_BIND 127.0.0.1

rm -f .env.bak

echo "==> .env ready for https://${DOMAIN}"
echo "==> Opening firewall 80/443 if ufw is active (may need sudo password)"
if command -v ufw >/dev/null 2>&1; then
    sudo ufw allow 80/tcp || true
    sudo ufw allow 443/tcp || true
    sudo ufw status || true
fi

echo "==> Deploy app + Caddy"
./scripts/deploy.sh

echo
echo "============================================================"
echo "Server is ready for DNS cutover."
echo
echo "Send this to the DNS person (copy/paste):"
echo
cat <<EOF
Нужно перевести DNS на новый сервер.

IP сервера: ${SERVER_IP}
Домен: ${DOMAIN}

Сделайте A-записи (IPv4):
  ${DOMAIN}        →  ${SERVER_IP}
  www.${DOMAIN}    →  ${SERVER_IP}

Если есть AAAA (IPv6) на старый хостинг — удалите или обновите.
TTL лучше поставить 300 (5 мин) перед сменой.

После смены DNS сайт откроется как https://${DOMAIN}
(SSL сертификат выпустится автоматически в течение нескольких минут).

Проверка с вашей стороны:
  dig +short ${DOMAIN} A
  dig +short www.${DOMAIN} A
Должны вернуть ${SERVER_IP}
EOF
echo "============================================================"
