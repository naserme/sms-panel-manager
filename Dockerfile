FROM php:8.2-fpm

# نصب اکستنشن‌های لازم

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    && docker-php-ext-install pdo pdo_mysql
# نصب composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# کل پروژه رو کپی کن داخل کانتینر
COPY . .

# نصب پکیج‌ها
RUN composer install --no-dev --no-interaction --optimize-autoloader

CMD ["php-fpm"]
