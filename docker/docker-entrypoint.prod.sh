#!/bin/bash
set -e

# Create .env if missing
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Set folder permissions
mkdir -p storage bootstrap/cache database
touch database/database.sqlite
chown -R www-data:www-data storage bootstrap/cache database
chmod -R 775 storage bootstrap/cache database

# Install PHP dependencies (if needed)
composer install --no-dev --optimize-autoloader --no-scripts

# Generate APP_KEY if missing
php artisan key:generate --force

# Run migrations
php artisan migrate --force

# Build frontend assets
npm ci
npm run build

# Start supervisord (nginx + php-fpm)
exec /usr/bin/supervisord -n -c /etc/supervisor/conf.d/supervisord.conf
