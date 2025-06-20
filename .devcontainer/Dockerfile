FROM mcr.microsoft.com/devcontainers/php:0-8.2

WORKDIR /app

COPY .. .

RUN apt-get update \
    && docker-php-ext-install bcmath