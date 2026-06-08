FROM php:8.4-fpm-alpine AS base

# Install system dependencies
RUN apk add --no-cache \
    nginx \
    supervisor \
    sqlite \
    sqlite-dev \
    nodejs \
    npm \
    curl \
    zip \
    unzip \
    libzip-dev \
    oniguruma-dev \
    icu-dev \
    && docker-php-ext-install \
    pdo_sqlite \
    mbstring \
    zip \
    intl \
    opcache

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy composer files first for caching
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

# Copy package.json for npm
COPY package.json package-lock.json* ./
RUN npm ci --production=false 2>/dev/null || true

# Copy application files
COPY . .

# Create .env from example so Laravel can initialize during build
RUN cp .env.example .env

# Build assets and finalize
RUN composer dump-autoload --optimize --no-dev \
    && npm run build 2>/dev/null || true \
    && php artisan route:cache \
    && php artisan view:cache

# Remove .env so Laravel reads from Railway's environment variables at runtime
RUN rm .env

# Create SQLite database directory
RUN mkdir -p /var/www/html/database \
    && touch /var/www/html/database/database.sqlite \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache \
    && chmod 664 /var/www/html/database/database.sqlite

# Create supervisord log directory
RUN mkdir -p /var/log/supervisor \
    && chown -R root:root /var/log/supervisor \
    && chmod 755 /var/log/supervisor

# Copy nginx and supervisor configs
COPY docker/nginx.conf /etc/nginx/http.d/default.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
