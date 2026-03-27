FROM php:8.2-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    nginx \
    supervisor \
    nodejs \
    npm \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    sqlite \
    sqlite-dev \
    oniguruma-dev \
    icu-dev \
    && docker-php-ext-install \
        pdo \
        pdo_sqlite \
        gd \
        zip \
        bcmath \
        mbstring \
        intl \
        pcntl \
    && rm -rf /var/cache/apk/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy composer files first (for layer caching)
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction

# Copy package files
COPY package.json package-lock.json ./

# Install Node dependencies and build assets
COPY resources ./resources
COPY vite.config.js ./

RUN npm ci && npm run build && rm -rf node_modules

# Copy the rest of the application
COPY . .

# Set permissions
RUN mkdir -p \
        storage/logs \
        storage/framework/cache \
        storage/framework/sessions \
        storage/framework/views \
        bootstrap/cache \
        database \
    && touch database/database.sqlite \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache database

# Copy config files
COPY docker/nginx.conf /etc/nginx/http.d/default.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Run composer scripts after full copy
RUN composer dump-autoload --optimize

EXPOSE 80

COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]
