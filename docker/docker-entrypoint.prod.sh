#!/bin/bash
set -e

# Only run Laravel runtime setup if artisan exists
if [ -f /var/www/html/artisan ]; then
    echo "Running Laravel setup..."

    # 1️⃣ Ensure .env exists
    if [ ! -f /var/www/html/.env ]; then
        echo ".env not found, copying from .env.example"
        cp /var/www/html/.env.example /var/www/html/.env
    fi

    # 2️⃣ Generate APP_KEY if not already set
    php /var/www/html/artisan key:generate --force

    # 3️⃣ Clear & cache config
    php /var/www/html/artisan config:clear
    php /var/www/html/artisan config:cache

    # 4️⃣ Run migrations if DB is available
    php /var/www/html/artisan migrate --force || true


    # Fix permissions so Nginx & PHP-FPM can read/write
    chown -R www-data:www-data /var/www/html
    chmod -R 755 /var/www/html
fi

# Start supervisord (runs PHP-FPM + Nginx)
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
