FROM php:fpm

# install dependencies
RUN apt-get update && apt-get install -y \
    mysql-client

# install php extensions
RUN docker-php-ext-install pdo_mysql