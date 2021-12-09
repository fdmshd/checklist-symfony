FROM php:7.4-fpm-alpine
RUN  php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
     php -r "if (hash_file('sha384', 'composer-setup.php') === '906a84df04cea2aa72f40b5f787e49f22d4c2f19492ac310e8cba5b96ac8b64115ac402c8cd292b8a03482574915d1a8') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
     php composer-setup.php && \
     php -r "unlink('composer-setup.php');" && \
     mv composer.phar /usr/local/bin/composer
RUN set -ex && \
    apk --no-cache --update add libzip-dev \
                           rabbitmq-c rabbitmq-c-dev \
                       --virtual .phpize-deps $PHPIZE_DEPS
RUN docker-php-ext-install pdo pdo_mysql zip sockets
RUN pecl install -o -f amqp
RUN docker-php-ext-enable amqp