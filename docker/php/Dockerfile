FROM php:8.4-fpm

# Install system deps + nginx + supervisor + procps (ps)
RUN apt-get update && apt-get install -y \
    nginx \
    supervisor \
    procps \
    libpng-dev libjpeg-dev libfreetype6-dev \
    libonig-dev libzip-dev libicu-dev \
    zip unzip git curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql mbstring zip exif pcntl intl \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php \
    -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

# Copy app code
COPY . .
COPY docker/docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh
ENTRYPOINT ["docker-entrypoint.sh"]

# ✅ Tell git this directory is safe BEFORE composer runs
RUN git config --global --add safe.directory /var/www/html

# Install prod dependencies
RUN composer install --no-dev --optimize-autoloader --no-scripts \
    && mkdir -p storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Copy configs
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY docker/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

EXPOSE 80

CMD ["/usr/bin/supervisord", "-n"]
