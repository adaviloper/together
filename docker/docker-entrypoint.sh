#!/bin/bash

set -e

# Only run Laravel runtime setup if artisan exists
if [ -f /var/www/html/artisan ]; then
    echo "Running Laravel setup..."
    # Generate app key if not present
    php /var/www/html/artisan key:generate --force || true
    # Clear and cache config
    php /var/www/html/artisan config:clear
    php /var/www/html/artisan config:cache
    # Run migrations if DB is available
    php /var/www/html/artisan migrate --force || true
fi

# Start supervisord
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
# Start PHP-FPM in background
php-fpm &

# Start Nginx in foreground
nginx -g "daemon off;"
