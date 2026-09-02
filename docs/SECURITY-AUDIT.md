# Аудит безопасности lumresidence — статус

Исходный отчёт: `Аудит_безопасности_и_качества_кода_lumresidence.pdf` (август 2026).

## Исправлено в коде

| # | Риск | Статус |
|---|------|--------|
| 5 | `canAccessPanel()` → true для всех | ✅ `is_admin` + allowlist `ADMIN_EMAILS` |
| 5 | Test user в DatabaseSeeder | ✅ только `local` |
| 6 | Расширение файла из имени клиента | ✅ whitelist по MIME в `LumImageOptimizer` |
| 7 | SVG upload + nosniff на `/images/` | ✅ SVG убран из upload; security headers в nginx `/images/` и `/build/`; deny `*.php` |
| 9 | XSS `{!! !!}` в location | ✅ `nl2br(e())` / `{{ }}` |
| 10 | Host header poisoning | ✅ не доверяем произвольному `Host:`; убран `X-Forwarded-Host` из trusted headers |
| 13 | Утечка деталей ошибок upload | ✅ generic message в prod |
| 12 | ManageAccount: unique email, logout other sessions, rate limit | ✅ |
| 15 | robots.txt /admin | ✅ `Disallow: /admin` |
| — | Google Ads gtag | ✅ `AW-11302085576` в layout |

## Остаётся (инфра / процесс)

| # | Риск | Рекомендация |
|---|------|----------------|
| 8 | Нет бэкапов SQLite + uploads | cron: `sqlite3 .backup` + tar volume → S3/другой хост |
| 11 | CSP для Exely + gtag | включить `Content-Security-Policy-Report-Only` в Caddy после проверки виджета |
| 14 | Password reset в Filament | `->passwordReset()` + реальный `MAIL_*` |
| 16 | CMS SELECT без кеша | memo в `HomeSection` / `PageSection` (perf) |
| 17 | Smoke-тесты роутов | `tests/Feature/PublicPagesTest.php` |
| 20–22 | Мёртвый код, deploy.sh sed, dev compose | по желанию, не блокер prod |

## Prod checklist

```bash
# .env
ADMIN_EMAILS=dimacake@gmail.com
APP_DEBUG=false
SESSION_SECURE_COOKIE=true

php artisan migrate --force
```

После деплоя: загрузка `.php` в `/images/` → 403; `/admin` не в robots; новый user без `is_admin` не входит в Filament.
