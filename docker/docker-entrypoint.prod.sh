#!/bin/bash
set -e

# Set folder permissions
mkdir -p storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

APP_KEY_FILE=storage/.app_key

if [ -n "$APP_KEY" ]; then
    sed -i "s|^APP_KEY=.*|APP_KEY=$APP_KEY|" .env
elif [ -f "$APP_KEY_FILE" ]; then
    sed -i "s|^APP_KEY=.*|APP_KEY=$(cat $APP_KEY_FILE)|" .env
else
    php artisan key:generate --force
    grep "^APP_KEY=" .env | sed 's/APP_KEY=//' > "$APP_KEY_FILE"
fi

# Ensure mysql user owns the data directory (bind mount may be root-owned)
chown -R mysql:mysql /var/lib/mysql

# Initialize MariaDB data directory if this is a fresh volume
if [ ! -d /var/lib/mysql/mysql ]; then
    mysql_install_db --user=mysql --datadir=/var/lib/mysql
fi

# Start MariaDB temporarily to run setup and migrations
# cd first so mysqld writes ddl_recovery.log to the datadir, not /var/www/html
cd /var/lib/mysql
mysqld_safe --datadir=/var/lib/mysql &
cd /var/www/html

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

# Run migrations — refresh if the schema version has changed
SCHEMA_VERSION_FILE="database/schema_version"
APPLIED_VERSION_FILE="/var/lib/mysql/.schema_version"

IMAGE_VERSION=$(cat "$SCHEMA_VERSION_FILE" 2>/dev/null || echo "0")
APPLIED_VERSION=$(cat "$APPLIED_VERSION_FILE" 2>/dev/null || echo "0")

if [ "$IMAGE_VERSION" != "$APPLIED_VERSION" ]; then
    echo "Schema version changed ($APPLIED_VERSION -> $IMAGE_VERSION): running migrate:fresh"
    php artisan migrate:fresh --force
    echo "$IMAGE_VERSION" > "$APPLIED_VERSION_FILE"
else
    php artisan migrate --force
fi

# Stop the temporary MariaDB (supervisord will manage it from here)
mysqladmin -u root shutdown
sleep 2

# Start supervisord (nginx + php-fpm + mariadb)
exec /usr/bin/supervisord -n -c /etc/supervisor/conf.d/supervisord.conf
