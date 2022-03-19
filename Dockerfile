FROM php:7.2-fpm-alpine3.12
WORKDIR /var/www
RUN docker-php-ext-install pdo pdo_mysql && docker-php-ext-enable pdo pdo_mysql
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN docker-php-ext-configure pdo_mysql --with-pdo-mysql=mysqlnd && docker-php-ext-configure mysqli --with-mysqli=mysqlnd && docker-php-ext-install pdo_mysql
