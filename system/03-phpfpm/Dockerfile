FROM php:7.4-fpm

RUN apt-get update -y &&\
    apt-get upgrade -y && \
    apt-get install -y git

RUN apt-get update && apt-get install -y libpq-dev
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql
RUN docker-php-ext-install pdo pdo_pgsql

RUN pecl install xdebug && docker-php-ext-enable xdebug

RUN echo "$(curl -sS https://composer.github.io/installer.sig) -" > composer-setup.php.sig \
        && curl -sS https://getcomposer.org/installer | tee composer-setup.php | sha384sum -c composer-setup.php.sig \
        && php composer-setup.php && rm composer-setup.php* \
        && chmod +x composer.phar && mv composer.phar /usr/bin/composer

COPY xdebug.ini  /usr/local/etc/php/conf.d/
COPY php.ini  /usr/local/etc/php/conf.d/

COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod 755 /usr/local/bin/docker-entrypoint.sh \
    && ln -s /usr/local/bin/docker-entrypoint.sh /

ENTRYPOINT ["docker-entrypoint.sh"]

CMD ["php-fpm", "-F"]

WORKDIR /var/www/symfony

EXPOSE 9001
