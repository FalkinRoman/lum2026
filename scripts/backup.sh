#!/usr/bin/env bash
# Daily content backup on the VPS (SQLite + CMS uploads).
#
# Run ON the server:
#   ./scripts/backup.sh
#
# Cron (as lumadm), once:
#   mkdir -p /opt/backups/lum
#   crontab -e
#   # add:
#   0 3 * * * cd /opt/lumresidence && ./scripts/backup.sh >> /opt/backups/lum/cron.log 2>&1

set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$ROOT_DIR"

HOST_BACKUP_DIR="${HOST_BACKUP_DIR:-/opt/backups/lum}"
mkdir -p "$HOST_BACKUP_DIR"

echo "[$(date -Is)] lum:backup starting…"

docker compose --profile production exec -T web php artisan lum:backup --prune=14

# Copy newest ZIP out of the container volume onto the host (survives volume mistakes).
latest="$(docker compose --profile production exec -T web sh -c 'ls -1t /var/www/html/storage/app/backups/lum-backup-*.zip 2>/dev/null | head -1' | tr -d '\r')"

if [ -n "$latest" ]; then
    name="$(basename "$latest")"
    docker compose --profile production cp "web:${latest}" "${HOST_BACKUP_DIR}/${name}"
    echo "[$(date -Is)] copied to ${HOST_BACKUP_DIR}/${name}"
else
    echo "[$(date -Is)] WARNING: no backup zip found in container" >&2
fi

# Host retention (14 days)
find "$HOST_BACKUP_DIR" -maxdepth 1 -type f -name 'lum-backup-*.zip' -mtime +14 -delete 2>/dev/null || true

echo "[$(date -Is)] done."
