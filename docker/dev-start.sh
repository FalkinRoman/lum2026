#!/bin/sh
set -e

if [ ! -x node_modules/.bin/vite ]; then
    npm ci
fi

npm run dev -- --host 0.0.0.0 --port 5173 &
vite_pid=$!

trap 'kill "$vite_pid" 2>/dev/null || true' EXIT INT TERM

php artisan serve --host=0.0.0.0 --port=8000
