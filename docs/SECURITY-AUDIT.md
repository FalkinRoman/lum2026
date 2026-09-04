# Аудит безопасности lumresidence — статус

Исходный отчёт: `Аудит_безопасности_и_качества_кода_lumresidence.pdf` (август 2026).  
Доп. разбор: `SECURITY_DETAILS_lumresidence_2026-09-02.md`.

## Исправлено в коде

| # | Риск | Статус |
|---|------|--------|
| 5 | `canAccessPanel()` → true для всех | ✅ `is_admin` + allowlist `ADMIN_EMAILS` |
| 5 | Test user в DatabaseSeeder | ✅ только `local` |
| 6 | Расширение файла из имени клиента | ✅ whitelist по MIME в `LumImageOptimizer` |
| 7 | SVG upload + nosniff на `/images/` | ✅ SVG убран; headers на `/images/` и `/build/` |
| C | nginx `deny *.php` недостижим из‑за `^~` | ✅ deny вложен внутрь `location ^~ /images/` |
| 9 | XSS `{!! !!}` в location | ✅ `nl2br(e())` / `{{ }}` |
| 10 | Host header poisoning | ✅ без произвольного `Host:`; без `X-Forwarded-Host` |
| 13 | Утечка деталей ошибок upload | ✅ generic message в prod |
| 12 | ManageAccount: unique email, rate limit | ✅ |
| B | `logoutOtherDevices(старый пароль)` → 500 | ✅ передаём новый пароль + try/catch |
| 15 | robots.txt /admin | ✅ `Disallow: /admin` |
| A | `APP_PORT` пустой → `:8080` в URL | ✅ compose `${APP_PORT-…}` (не `:-`) |
| 21 | `env_get` жрёт пробелы | ✅ trim только обрамляющих кавычек |
| — | Google Ads gtag | ✅ `AW-11302085576` в layout |

## Остаётся (инфра / процесс / не срочно)

| # | Риск | Рекомендация |
|---|------|----------------|
| 8 | Нет бэкапов SQLite + uploads | cron: `sqlite3 .backup` + tar volume → off-site |
| 11 | CSP для Exely + gtag | сначала Report-Only в Caddy после DNS |
| 14 | Password reset в Filament | ✅ `->passwordReset()`; на проде нужен Gmail app password в `.env` (+ 2-й админ желателен) |
| 16 | CMS SELECT без кеша | memo в `HomeSection` / `PageSection` (perf) |
| 17 | Smoke-тесты роутов | `tests/Feature/PublicPagesTest.php` |
| 18–20 | Blade/Content рефактор, мёртвый код | по желанию, не блокер prod |

## Prod checklist

```bash
# .env
ADMIN_EMAILS=dimacake@gmail.com
APP_DEBUG=false
SESSION_SECURE_COOKIE=true
# domain mode: APP_PORT must be empty (deploy.sh sets this)

php artisan migrate --force
```

После деплоя (domain mode):
```bash
curl -s http://127.0.0.1:8080/ | grep -c 'lumresidence.com:8080'   # → 0
curl -o /dev/null -w '%{http_code}' http://127.0.0.1:8080/images/lum/x.php  # → 403
```

**Важно:** `./scripts/deploy.sh` не трогает volume `lum_storage` (SQLite + uploads из админки). CMS-контент и картинки сохраняются.
