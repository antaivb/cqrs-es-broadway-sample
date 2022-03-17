FROM victorlopezsanchezz/docker-php-fpm-with-extensions:8.1

RUN mkdir -p /var/www/app-api

WORKDIR /var/www/app-api

RUN curl -sS https://getcomposer.org/installer | php
RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv composer.phar /usr/local/bin/composer

COPY composer.json /var/www/app-api
COPY composer.lock /var/www/app-api

RUN composer install --no-autoloader --no-scripts --prefer-dist --no-autoloader --no-progress --no-suggest
RUN mkdir -p /var/www/app-api/boot


RUN mkdir -p var/cache
RUN mkdir -p var/logs
RUN mkdir -p var/sessions

RUN mkdir -p src
COPY src src

RUN mkdir -p \
 public \
 public/images/avatars \
 public/images/background \
 public/attachments

COPY . /var/www/app-api/

RUN composer install && \
    composer dump-env prod

RUN find var -exec chown www-data: {} +

CMD ["bash", "start.sh"]
