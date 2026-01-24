FROM php:8.4-fpm

ARG HOST_UID=1000
ARG HOST_GID=1000

# System deps + PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libzip-dev \
    libicu-dev \
    zip \
    unzip \
    git \
    curl \
    ca-certificates \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        gd pdo pdo_mysql mbstring zip exif pcntl intl \
    && rm -rf /var/lib/apt/lists/*

# Node (optional, but you had it)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@latest

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin \
    --filename=composer

# Non-root user matching host
RUN groupadd -g ${HOST_GID} appgroup \
    && useradd -u ${HOST_UID} -g appgroup -m appuser

WORKDIR /var/www/html

# Laravel writable dirs
RUN mkdir -p storage bootstrap/cache \
    && chown -R appuser:appgroup /var/www/html

# Avoid git safe.directory warnings
RUN git config --system --add safe.directory /var/www/html

USER appuser

CMD ["php-fpm"]
