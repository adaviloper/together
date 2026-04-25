#!/bin/bash
set -e

# Set folder permissions
mkdir -p storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Override APP_KEY if provided via environment
if [ -n "$APP_KEY" ]; then
    sed -i "s|^APP_KEY=.*|APP_KEY=$APP_KEY|" .env
fi

# Cache Laravel config and views for performance
# Note: route:cache is skipped due to Filament route name conflicts
php artisan config:cache
php artisan view:cache

# Run migrations
php artisan migrate --force

# Start supervisord (nginx + php-fpm)
exec /usr/bin/supervisord -n -c /etc/supervisor/conf.d/supervisord.conf
