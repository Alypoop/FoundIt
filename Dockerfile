FROM php:8.2-fpm

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    zip \
    git \
    unzip \
    curl \
    gnupg \
    && curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# First copy only composer files
COPY composer.json composer.lock ./

# Install dependencies first
RUN composer install --no-dev --no-scripts --no-autoloader

# Then require additional packages
RUN composer require league/flysystem-aws-s3-v3 --no-scripts

# Now copy the rest of the application
COPY . .

# Complete the installation
RUN composer install --no-dev --optimize-autoloader

RUN composer dump-autoload

RUN npm install && npm run build

RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 8888

CMD bash -c "php artisan config:clear && \
    php artisan cache:clear && \
    php artisan migrate --force && \
    php artisan db:seed --force --verbose && \
    php artisan serve --host=0.0.0.0 --port=8888"
