# Đường dẫn đến Dockerfile gốc trong vendor
DOCKERFILE_PATH=${1:-"./vendor/laravel/sail/runtimes/8.2/Dockerfile"}
DOCKERFILE_SQLSRV=${2:-"./vendor/laravel/sail/runtimes/8.2/Dockerfile_sqlsrv"}

SQLSRV_INSTALL=$(
    cat <<EOF
    && curl -sSL -O https://packages.microsoft.com/config/ubuntu/\$(grep VERSION_ID /etc/os-release | cut -d '"' -f 2)/packages-microsoft-prod.deb \\
    && dpkg -i packages-microsoft-prod.deb \\
    && rm packages-microsoft-prod.deb \\

    && ACCEPT_EULA=Y apt-get install -y msodbcsql18 \\
    && ACCEPT_EULA=Y apt-get install -y mssql-tools18 \\
    && apt-get install -y unixodbc-dev \\

EOF
)

PHPSQLSRV_INSTALL=$(
    cat <<EOF
    # Install PHP extensions for SQL Server \\
    && pecl install sqlsrv \\
    && pecl install pdo_sqlsrv \\
    && su \\
    && printf "; priority=20\nextension=sqlsrv.so\n" > /etc/php/8.2/mods-available/sqlsrv.ini \\
    && printf "; priority=30\nextension=pdo_sqlsrv.so\n" > /etc/php/8.2/mods-available/pdo_sqlsrv.ini \\
    && exit \\
    && phpenmod sqlsrv pdo_sqlsrv \\
EOF
)

# echo "--- Dockerfile before modification ---"
# cat $DOCKERFILE_PATH
# ORIGINAL_CONTENT=$(cat "$DOCKERFILE_PATH")

while IFS= read -r line; do
    echo "$line"
    if [[ "$line" == *"&& apt-get install -y postgresql-client-"* ]]; then
        echo "$SQLSRV_INSTALL"
        echo "$PHPSQLSRV_INSTALL"
    fi
    # done <"$DOCKERFILE_PATH"
done <"$DOCKERFILE_PATH" >"$DOCKERFILE_SQLSRV"
