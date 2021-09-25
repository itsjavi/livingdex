FROM php:8.0-fpm as base

ENV PHP_MEMORY_LIMIT=${PHP_MEMORY_LIMIT:-"256M"}
ENV COMPOSER_ALLOW_SUPERUSER=${COMPOSER_ALLOW_SUPERUSER:-1}
ENV COMPOSER_PROCESS_TIMEOUT=${COMPOSER_PROCESS_TIMEOUT:-0}
ENV COMPOSER_MEMORY_LIMIT=${COMPOSER_MEMORY_LIMIT:-"2G"}

RUN apt-get -yq update && apt-get -yqq install \
libzip-dev git ssh zip imagemagick

RUN echo "memory_limit = ${PHP_MEMORY_LIMIT}" > /usr/local/etc/php/conf.d/php_memory.ini

RUN docker-php-ext-install pdo_mysql
RUN pecl install apcu
RUN docker-php-ext-install zip
RUN docker-php-ext-enable apcu

WORKDIR /usr/src/app

RUN PATH=$PATH:/usr/src/app/vendor/bin:bin
RUN mkdir -p ~/.ssh && ssh-keyscan -H github.com >>~/.ssh/known_hosts

COPY --from=composer:2.0 /usr/bin/composer /usr/local/bin/composer

#----------------------------
# pogodata exporter
#----------------------------
FROM python:3.9 as pogodata-exporter
RUN apt-get -yq update && apt-get -yqq install jq

WORKDIR /usr/src/app

RUN printf '#!/usr/bin/env bash \nmkdir -p /usr/src/data \n ' > /usr/src/app/pogodata-dump.sh && \
    printf 'echo "Dumping PoGO data to JSON..."\n' >> /usr/src/app/pogodata-dump.sh && \
    printf 'python3 /usr/src/app/pogo-dumper/dumper.py moves > /usr/src/data/pogo-moves.json\n' >> /usr/src/app/pogodata-dump.sh && \
    printf 'python3 /usr/src/app/pogo-dumper/dumper.py pokemon > /usr/src/data/pogo-pokemon.json\n' >> /usr/src/app/pogodata-dump.sh && \
    chmod +x /usr/src/app/pogodata-dump.sh

COPY src/Scripts/pogo-dumper-py/ /usr/src/app

RUN echo "Setting up pogodata..." && \
   python3 -m pip install pogodata && \
   python3 -m pip install .

RUN /usr/src/app/pogodata-dump.sh

ENTRYPOINT ["/usr/src/app/pogodata-dump.sh"]

#----------------------------
# dist data builder
#----------------------------
FROM base as builder-with-source

ENV DATABASE_URL="sqlite:///%kernel.project_dir%/var/livingdex.sqlite"
ENV APP_ENV=prod
ENV APP_DEBUG=0

WORKDIR /usr/src/app

# Add files required to install dependencies
COPY ./composer.json /usr/src/app/composer.json
COPY ./composer.lock /usr/src/app/composer.lock

# Install dependencies. Docker will install them again if the previous files changed.
RUN composer install -v -q --no-dev --no-scripts

# Copy the rest of the app.
# From now on, if any file changes, docker will invalidate
# any following cached step.
COPY . /usr/src/app

RUN make clean && make post-composer-install

# Add Pokemon GO data from the previous stage
RUN rm -f /usr/src/app/src/DataSources/Data/pogo/*.json
COPY --from=pogodata-exporter /usr/src/data/ /usr/src/app/src/DataSources/Data/pogo

# Generate DB schema and data
RUN make db-schema && make db-data-from-fixtures

# Export DB data
ENTRYPOINT ["make"]
CMD ["dist"]
