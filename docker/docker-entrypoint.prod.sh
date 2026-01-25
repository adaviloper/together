#!/bin/bash

set -u
set -o pipefail

cd /var/www/html

echo "▶ Entrypoint starting…"

# Ensure .env exists
if [ ! -f .env ]; then
  echo "▶ Creating .env"
  cp .env.example .env || true
fi

# Generate key if missing
if ! grep -q '^APP_KEY=' .env || grep -q 'APP_KEY=$' .env; then
  echo "▶ Generating APP_KEY"
  php artisan key:generate --force || true
fi

echo "▶ Clearing & caching config"
php artisan config:clear || true
php artisan config:cache || true

echo "▶ Running migrations (non-fatal)"
php artisan migrate --force || true

echo "▶ Starting supervisord"
exec /usr/bin/supervisord -n -c /etc/supervisor/conf.d/supervisord.conf
