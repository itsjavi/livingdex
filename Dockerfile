FROM php:8.0-fpm-buster as php8-imagemagick

ENV DEBIAN_FRONTEND=noninteractive
ENV TZ "Europe/Berlin"
ENV LC_ALL en_US.UTF-8
ENV LANG en_US.UTF-8
ENV LANGUAGE en_US.UTF-8
ENV PHP_MEMORY_LIMIT=${PHP_MEMORY_LIMIT:-"256M"}
ENV COMPOSER_ALLOW_SUPERUSER=${COMPOSER_ALLOW_SUPERUSER:-1}
ENV COMPOSER_PROCESS_TIMEOUT=${COMPOSER_PROCESS_TIMEOUT:-0}
ENV COMPOSER_MEMORY_LIMIT=${COMPOSER_MEMORY_LIMIT:-"2G"}

# ensure local binaries are preferred over distro ones
ENV PATH /usr/local/bin:$PATH

RUN rm /bin/sh && ln -s /bin/bash /bin/sh
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apt-get update
RUN apt-get install -y \
    sudo \
    autoconf \
    autogen \
    locales \
    locales-all \
    wget \
    zip \
    libzip-dev \
    unzip \
    curl \
    rsync \
    ssh \
    openssh-client \
    git \
    build-essential \
    apt-utils \
    software-properties-common \
    nasm \
    libjpeg-dev \
    libpng-dev \
    libpng16-16 \
    imagemagick \
    libmagickwand-dev \
    optipng \
    jq \
    pv \
    gnupg

# SSH
RUN mkdir ~/.ssh
RUN touch ~/.ssh_config
RUN mkdir -p ~/.ssh && ssh-keyscan -H github.com >>~/.ssh/known_hosts

# ImageMagick config
RUN rm -f /etc/ImageMagick-6/policy.xml
COPY resources/docker/imagemagick-policy.xml /etc/ImageMagick-6/policy.xml

# PHP extensions
RUN docker-php-ext-install pdo_mysql
RUN pecl install apcu
RUN docker-php-ext-install zip
RUN docker-php-ext-install gd
RUN docker-php-ext-enable apcu
RUN docker-php-ext-enable gd
RUN echo "memory_limit = ${PHP_MEMORY_LIMIT}" > /usr/local/etc/php/conf.d/php_memory.ini

RUN pecl install imagick
RUN docker-php-ext-enable imagick

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

WORKDIR /usr/src/app

# ----------------------------------------------------------------------------
# ----------------------------------------------------------------------------

FROM node:16 as node
RUN npm install npm@7 -g
WORKDIR /usr/src/app
EXPOSE 3000

# ----------------------------------------------------------------------------
# ----------------------------------------------------------------------------

FROM python:3.9 as python

ENV DATA_DIR=/usr/shared/data

RUN apt-get -yq update && apt-get -yqq install jq
RUN pip install setuptools

# Install pogo-dumper app
COPY ./apps/pogo-dumper /usr/src/pogo-dumper
WORKDIR /usr/src/pogo-dumper
RUN ls /usr/src/pogo-dumper/pogo-dumper && \
  echo "Setting up pogodata..." && \
  pip install .

WORKDIR /usr/src/app
