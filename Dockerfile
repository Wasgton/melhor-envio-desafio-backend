FROM php:8.2-fpm

WORKDIR /var/www/html

ARG user
ARG uid

RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user && chown -R $user:$uid /home/$user && chown -R $user:$uid /var/www/html//

COPY --chown=$user:$uid . /var/www/html/

RUN apt-get update
RUN apt-get install -y \
    git \
    zip \
    curl \
    wget \
    sudo \
    unzip \
    libicu-dev \
    libbz2-dev \
    libpng-dev \
    libjpeg-dev \
    libmcrypt-dev \
    libreadline-dev \
    libfreetype6-dev \
    g++ \
    nano \
    cron

RUN echo upload_max_filesize = 200M >> /usr/local/etc/php/php.ini
RUN echo post_max_size = 200M >> /usr/local/etc/php/php.ini

RUN wget -c "https://xdebug.org/files/xdebug-3.3.2.tgz"
RUN tar -xf xdebug-3.3.2.tgz
RUN cd xdebug-3.3.2 && phpize && ./configure && make && make install
RUN echo "zend_extension=xdebug.so" > /usr/local/etc/php/conf.d/xdebug.ini

RUN echo "xdebug.mode=debug,coverage" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.discover_client_host=1" >> /usr/local/etc/php/conf.d/xdebug.ini

RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/bin/composer
RUN docker-php-ext-install pdo pdo_mysql

USER $user
CMD ["php-fpm"]