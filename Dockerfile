FROM php:7.4-fpm

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get update && apt-get install -y \
      libzip-dev \
      sqlite3 \
      git \
      libpq-dev \
      && docker-php-ext-install zip pdo pdo_pgsql

RUN curl https://cli-assets.heroku.com/install.sh | sh

WORKDIR /app
