FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    git unzip libzip-dev default-mysql-client \
    && docker-php-ext-install pdo pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copiamos TODO el proyecto primero (para que exista artisan)
COPY . .

# Instalamos dependencias (ya puede ejecutar scripts)
RUN composer install --no-interaction

EXPOSE 8000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]

