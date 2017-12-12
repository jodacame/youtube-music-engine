FROM php:7-apache
ARG userid=1000
ENV DOCKER_UID $userid
COPY php.ini /usr/local/etc/php/
RUN apt update
RUN apt install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev sudo
RUN docker-php-ext-install pdo pdo_mysql mbstring mysqli gd iconv
RUN a2enmod rewrite
RUN service apache2 restart

RUN usermod -u $DOCKER_UID www-data \
    && groupmod -g $DOCKER_UID www-data \
    && chsh -s /bin/bash www-data \
    && echo "www-data ALL=(ALL) NOPASSWD:ALL" > /etc/sudoers.d/90-www-data

RUN chown -R $DOCKER_UID /var/www/html
