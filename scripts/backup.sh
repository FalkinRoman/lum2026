#!/usr/bin/env bash
# Content backup on the VPS (SQLite CMS DB + admin uploads).
#
# Uploads are ~370 MB and change rarely, the database is ~0.5 MB, so:
#   every day  → database-only snapshot   (lum-backup-db-<stamp>.zip)
#   Sundays    → full snapshot            (lum-backup-<stamp>.zip)
# A full run also happens automatically when no full backup exists yet.
#
# Force a full run on any day:
#   FULL=1 ./scripts/backup.sh
#
# Cron (as lumadm), once:
#   crontab -e
#   0 3 * * * cd /opt/lumresidence && ./scripts/backup.sh >> ~/backups/lum/cron.log 2>&1

set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$ROOT_DIR"

HOST_BACKUP_DIR="${HOST_BACKUP_DIR:-$HOME/backups/lum}"
mkdir -p "$HOST_BACKUP_DIR"

# How many archives of each kind to keep on the host.
# Container-side retention lives in App\Support\SiteBackup (KEEP_DB / KEEP_FULL).
DB_KEEP="${DB_KEEP:-7}"
FULL_KEEP="${FULL_KEEP:-4}"

FULL_GLOB="lum-backup-[0-9]*.zip"
DB_GLOB="lum-backup-db-*.zip"

have_full_backup () {
    ls -1 "$HOST_BACKUP_DIR"/$FULL_GLOB >/dev/null 2>&1
}

if [ "${FULL:-0}" = "1" ] || [ "$(date +%u)" = "7" ] || ! have_full_backup; then
    MODE="full"
    ARTISAN_ARGS=""
    GLOB="$FULL_GLOB"
else
    MODE="db"
    ARTISAN_ARGS="--db-only"
fi
[ "$MODE" = "db" ] && GLOB="$DB_GLOB"

echo "[$(date -Is)] lum:backup starting (mode=${MODE})…"

# shellcheck disable=SC2086
docker compose --profile production exec -T web php artisan lum:backup $ARTISAN_ARGS

# Copy the archive just made out of the container volume onto the host,
# so a lost/damaged Docker volume does not take the backups with it.
latest="$(docker compose --profile production exec -T web sh -c "ls -1t /var/www/html/storage/app/backups/${GLOB} 2>/dev/null | head -1" | tr -d '\r')"

if [ -n "$latest" ]; then
    name="$(basename "$latest")"
    docker compose --profile production cp "web:${latest}" "${HOST_BACKUP_DIR}/${name}"
    echo "[$(date -Is)] copied to ${HOST_BACKUP_DIR}/${name}"
else
    echo "[$(date -Is)] WARNING: no ${MODE} backup zip found in container" >&2
fi

# Host retention, by count and per kind — so a run of daily DB snapshots never
# evicts the weekly full backups, and the newest N always survive even if cron
# was down for a while (which age-based pruning would not guarantee).
prune_host () {
    local glob="$1" keep="$2" old
    old="$(ls -1t "$HOST_BACKUP_DIR"/$glob 2>/dev/null | tail -n "+$((keep + 1))" || true)"
    [ -z "$old" ] && return 0
    echo "$old" | while IFS= read -r file; do
        rm -f "$file" && echo "[$(date -Is)] pruned $(basename "$file")"
    done
}

prune_host "$DB_GLOB" "$DB_KEEP"
prune_host "$FULL_GLOB" "$FULL_KEEP"

echo "[$(date -Is)] done. Host dir: $(du -sh "$HOST_BACKUP_DIR" | cut -f1)"
