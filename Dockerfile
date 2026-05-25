# Stage 1: Build front-end assets
FROM node:20-alpine AS assets-builder
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY . .
RUN npm run build

# Stage 2: Final application container
FROM php:8.2-fpm-alpine

# Install system dependencies & PHP extensions
RUN apk add --no-cache \
    nginx \
    supervisor \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    openssl-dev \
    pcre-dev \
    $PHPIZE_DEPS

# Install MongoDB extension
RUN pecl install mongodb \
    && docker-php-ext-enable mongodb

# Install other standard PHP extensions
RUN docker-php-ext-install bcmath gd pdo_mysql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Copy built assets from builder stage
COPY --from=assets-builder /app/public/build ./public/build

# Install composer production dependencies
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Configure Nginx, supervisord, and directory permissions
RUN mkdir -p /run/nginx /var/log/supervisor \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Copy Nginx config and supervisor configuration
COPY ./docker/nginx.conf /etc/nginx/nginx.conf
COPY ./docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
