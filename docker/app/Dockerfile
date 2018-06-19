FROM php:7.2-fpm-alpine

LABEL maintainer="pvormittag@engrain.com"

# System and PHP Dependencies

RUN apk add --update --no-cache \
    git \
    subversion \
    zlib-dev \
  && NPROC=$(getconf _NPROCESSORS_ONLN) \
  && docker-php-ext-install -j${NPROC} iconv pdo pdo_mysql zip

# Composer

ENV COMPOSER_ALLOW_SUPERUSER 1
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
  && php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
  && php composer-setup.php \
  && php -r "unlink('composer-setup.php');" \
  && mv composer.phar /usr/local/bin/composer
