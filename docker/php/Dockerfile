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
    libicu-dev \
    ca-certificates \
    gnupg \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql mbstring zip exif pcntl intl

# Install Node.js (LTS version)
RUN mkdir -p /etc/apt/keyrings \
    && curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg \
    && echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_20.x nodistro main" | tee /etc/apt/sources.list.d/nodesource.list \
    && apt-get update \
    && apt-get install -y nodejs \
    && npm install -g npm@latest

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
