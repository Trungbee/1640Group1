FROM php:8.2-cli

# Cài extension
RUN apt-get update && apt-get install -y \
    git unzip curl libpq-dev libonig-dev libxml2-dev zip \
    && docker-php-ext-install pdo pdo_pgsql mbstring bcmath

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy composer trước để cache tốt
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader

# Copy code sau
COPY . .

# Permission
RUN chmod -R 775 storage bootstrap/cache

# Port Render
EXPOSE 10000

# Start app
CMD php artisan serve --host=0.0.0.0 --port=10000