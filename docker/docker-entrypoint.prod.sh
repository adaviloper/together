#!/bin/bash
set -e

# Set folder permissions
mkdir -p storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Apply any environment variables that match keys in .env.example
while IFS= read -r line; do
    [[ "$line" =~ ^[[:space:]]*# ]] && continue
    [[ "$line" != *"="* ]] && continue
    key="${line%%=*}"
    key="${key//[[:space:]]/}"
    [[ -z "$key" ]] && continue
    if [ "${!key+x}" = x ]; then
        sed -i "s|^${key}=.*|${key}=${!key}|" .env
    fi
done < .env.example

# Ensure APP_KEY is set — fall back to a persisted key or generate a fresh one
APP_KEY_FILE=storage/.app_key
if [ -z "$APP_KEY" ]; then
    if [ -f "$APP_KEY_FILE" ]; then
        sed -i "s|^APP_KEY=.*|APP_KEY=$(cat $APP_KEY_FILE)|" .env
    else
        php artisan key:generate --force
        grep "^APP_KEY=" .env | sed 's/APP_KEY=//' > "$APP_KEY_FILE"
    fi
fi

# Initialize MariaDB data directory if this is a fresh volume
if [ ! -d /var/lib/mysql/mysql ]; then
    mysql_install_db --user=mysql --datadir=/var/lib/mysql
fi

# Start MariaDB temporarily to run setup and migrations
mysqld_safe --datadir=/var/lib/mysql &

until mysqladmin ping -h 127.0.0.1 --silent 2>/dev/null; do sleep 1; done

# Create database and user if they don't exist
mysql -u root -e "
    CREATE DATABASE IF NOT EXISTS \`together\`;
    CREATE USER IF NOT EXISTS 'laravel'@'localhost' IDENTIFIED BY '${DB_PASSWORD:-password}';
    GRANT ALL ON \`together\`.* TO 'laravel'@'localhost';
    FLUSH PRIVILEGES;
"

# Cache Laravel config and views for performance
# Note: route:cache is skipped due to Filament route name conflicts
php artisan config:cache
php artisan view:cache

# Run migrations
php artisan migrate --force

# Stop the temporary MariaDB (supervisord will manage it from here)
mysqladmin -u root shutdown
sleep 2

# Start supervisord (nginx + php-fpm + mariadb)
exec /usr/bin/supervisord -n -c /etc/supervisor/conf.d/supervisord.conf
