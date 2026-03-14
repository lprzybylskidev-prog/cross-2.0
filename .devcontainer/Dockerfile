FROM php:8.4-fpm-bookworm

ARG USERNAME=vscode
ARG USER_UID=1000
ARG USER_GID=1000
ARG NODE_MAJOR=22

ENV DEBIAN_FRONTEND=noninteractive \
    COMPOSER_ALLOW_SUPERUSER=1

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        bash \
        ca-certificates \
        curl \
        git \
        gnupg \
        gosu \
        iputils-ping \
        libcurl4-openssl-dev \
        libicu-dev \
        libonig-dev \
        libpq-dev \
        libxml2-dev \
        libzip-dev \
        netcat-openbsd \
        openssh-client \
        procps \
        unzip \
        zip \
    && mkdir -p /etc/apt/keyrings \
    && curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg \
    && echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_${NODE_MAJOR}.x nodistro main" > /etc/apt/sources.list.d/nodesource.list \
    && apt-get update \
    && apt-get install -y --no-install-recommends nodejs \
    && docker-php-ext-configure intl \
    && docker-php-ext-install -j"$(nproc)" \
        bcmath \
        intl \
        mbstring \
        opcache \
        pcntl \
        pdo \
        pdo_pgsql \
        pgsql \
        xml \
        zip \
    && pecl install redis xdebug \
    && docker-php-ext-enable redis xdebug \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && if ! getent group "${USER_GID}" >/dev/null; then groupadd --gid "${USER_GID}" "${USERNAME}"; fi \
    && if id -u "${USERNAME}" >/dev/null 2>&1; then \
         usermod --uid "${USER_UID}" --gid "${USER_GID}" "${USERNAME}"; \
       else \
         useradd --uid "${USER_UID}" --gid "${USER_GID}" --create-home --shell /bin/bash "${USERNAME}"; \
       fi \
    && usermod --append --groups www-data "${USERNAME}" \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/pear

COPY docker/php/php.ini /usr/local/etc/php/conf.d/99-app.ini
COPY docker/php/xdebug.ini /usr/local/etc/php/conf.d/98-xdebug.ini
COPY docker/php/entrypoint.sh /usr/local/bin/container-entrypoint
COPY docker/php/setup-ssh.sh /usr/local/bin/setup-ssh

RUN chmod +x /usr/local/bin/container-entrypoint /usr/local/bin/setup-ssh \
    && mkdir -p /workspace \
    && chown -R "${USERNAME}:${USERNAME}" /workspace

WORKDIR /workspace

ENTRYPOINT ["container-entrypoint"]
CMD ["php-fpm"]
