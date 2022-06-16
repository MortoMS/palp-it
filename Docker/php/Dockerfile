FROM php:7.4-apache
RUN docker-php-ext-install pdo_mysql mysqli

# Instala o composer
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php && \
  php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
  rm composer-setup.php

RUN a2enmod rewrite
RUN a2enmod negotiation