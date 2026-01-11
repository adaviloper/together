# docker/php/Dockerfile
# ---------------------

# Base PHP-FPM image
FROM php:8.4-fpm

# Build arguments for host UID/GID
ARG HOST_UID=1000
ARG HOST_GID=1000

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql mbstring zip exif pcntl \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Create a non-root user that matches the host UID/GID
RUN groupadd -g ${HOST_GID} appgroup \
    && useradd -u ${HOST_UID} -g ${HOST_GID} -m -s /bin/sh appuser

# Set working directory
WORKDIR /var/www/html

# Switch to non-root user
USER appuser

# Ensure Laravel storage and bootstrap/cache directories exist and are writable
RUN mkdir -p storage bootstrap/cache \
    && chown -R appuser:appgroup storage bootstrap/cache

# Configure git to avoid safe.directory warnings
RUN git config --global --add safe.directory /var/www/html

# Expose PHP-FPM port (for Nginx reverse proxy)
EXPOSE 9000

# Use the default php-fpm entrypoint
CMD ["php-fpm"]
