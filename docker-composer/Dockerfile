FROM ubuntu:24.04

LABEL maintainer="Tran Ngoc Duc"

ARG WWWGROUP
ARG NODE_VERSION=24
ARG POSTGRES_VERSION=18

WORKDIR /var/www/html

ENV DEBIAN_FRONTEND=noninteractive
ENV TZ=UTC
ENV LANG=C.UTF-8
ENV SUPERVISOR_PHP_COMMAND="/usr/bin/php -d variables_order=EGPCS /var/www/html/artisan serve --host=0.0.0.0 --port=80"
ENV SUPERVISOR_PHP_USER="sail"

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN printf '%s\n' \
    "Acquire::http::Pipeline-Depth 0;" \
    "Acquire::http::No-Cache true;" \
    "Acquire::BrokenProxy true;" \
    "APT::Get::Assume-Yes \"yes\";" \
    "APT::Install-Recommends \"no\";" \
    "Acquire::Languages \"none\";" \
    "quiet \"yes\";" > /etc/apt/apt.conf.d/99custom

RUN apt-get update
RUN mkdir -p /etc/apt/keyrings
RUN apt-get install -y gnupg gosu curl ca-certificates zip unzip git supervisor sqlite3 libcap2-bin libpng-dev python3 dnsutils librsvg2-bin fswatch ffmpeg nano
RUN apt-get install -y libgd3 php-cli php-dev php-pgsql php-sqlite3 php-gd php-imagick php-curl php-mongodb php-imap php-mysql php-mbstring php-xml php-zip php-bcmath php-soap php-intl php-readline
RUN curl -sLS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer
RUN curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg \
    && echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_$NODE_VERSION.x nodistro main" > /etc/apt/sources.list.d/nodesource.list \
    && apt-get update \
    && apt-get install -y nodejs \
    && npm install -g npm \
    && npm install -g pnpm \
    && npm install -g bun \
    && corepack enable \
    && corepack prepare yarn@stable --activate
RUN curl -sS https://www.postgresql.org/media/keys/ACCC4CF8.asc | gpg --dearmor | tee /etc/apt/keyrings/pgdg.gpg >/dev/null \
    && echo "deb [signed-by=/etc/apt/keyrings/pgdg.gpg] http://apt.postgresql.org/pub/repos/apt noble-pgdg main" > /etc/apt/sources.list.d/pgdg.list \
    && apt-get update \
    && apt-get install -y mysql-client \
    && apt-get install -y postgresql-client-$POSTGRES_VERSION \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN curl -sS https://ppa.diepxuan.com/install.sh | bash -s -- --repository-only

RUN mkdir -p /opt/microsoft/msodbcsql18 && \
    touch /opt/microsoft/msodbcsql18/ACCEPT_EULA

RUN apt-get install -y msodbcsql18 php8.3-pdo-sqlsrv php8.3-sqlsrv \
    && phpenmod sqlsrv pdo_sqlsrv

RUN userdel -r ubuntu
RUN groupadd --force -g $WWWGROUP sail
RUN useradd -ms /bin/bash --no-user-group -g $WWWGROUP -u 1337 sail
RUN git config --global --add safe.directory /var/www/html

COPY start-container /usr/local/bin/start-container
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
RUN chmod +x /usr/local/bin/start-container

COPY php.ini /tmp/99-sail.ini
RUN for php_version in /etc/php/*; do \
        if [ -d "$php_version/cli/conf.d" ]; then \
            cp /tmp/99-sail.ini "$php_version/cli/conf.d/99-sail.ini"; \
        fi \
    done && \
    rm /tmp/99-sail.ini

EXPOSE 80/tcp

ENTRYPOINT ["start-container"]
