# Đường dẫn đến Dockerfile gốc trong vendor
DOCKERFILE_PATH=${1:-"./vendor/laravel/sail/runtimes/8.2/Dockerfile"}
DOCKERFILE_SQLSRV=${2:-"./vendor/laravel/sail/runtimes/8.2/Dockerfile_sqlsrv"}

SQLSRV_INSTALL=$(
    cat <<EOF
    # Install deps & add Microsoft repo
    && apt-get install -y gnupg curl apt-transport-https lsb-release \\
    && curl -fsSL https://packages.microsoft.com/keys/microsoft.asc | gpg --dearmor -o /usr/share/keyrings/microsoft-prod.gpg \\
    && curl -fsSL https://packages.microsoft.com/config/ubuntu/22.04/prod.list > /etc/apt/sources.list.d/mssql-release.list \\
    && apt-get update \\
    # Install ODBC and SQL Server Driver
    && ACCEPT_EULA=Y apt-get install -y --no-install-recommends unixodbc-dev msodbcsql18 \\
EOF
)

PHPSQLSRV_INSTALL=$(
    cat <<EOF
    # Install PHP extensions for SQL Server \\
    \t&& apt-get install sqlsrv pdo_sqlsrv \\
    # \t&& pecl install sqlsrv pdo_sqlsrv \\
EOF
)

# echo "--- Dockerfile before modification ---"
# cat $DOCKERFILE_PATH
ORIGINAL_CONTENT=$(cat "$DOCKERFILE_PATH")

while IFS= read -r line; do
    echo "$line"
    if [[ "$line" == *"&& apt-get install -y postgresql-client-"* ]]; then
        echo "$SQLSRV_INSTALL"
        echo "$PHPSQLSRV_INSTALL"
    fi
    # if [[ "$line" == *"&& apt-get install -y postgresql-client-"* ]]; then
    #     echo "$SQLSRV_INSTALL"
    # fi
    # done <"$DOCKERFILE_PATH"
done <"$DOCKERFILE_PATH" >"$DOCKERFILE_SQLSRV"

# # Lệnh này tìm dòng `&& docker-php-ext-enable redis igbinary msgpack \\` và chèn lệnh kích hoạt.
# sed -i '/&& docker-php-ext-enable redis igbinary msgpack \\/a \
# # Enable PHP extensions for SQL Server \
# \t&& docker-php-ext-enable sqlsrv pdo_sqlsrv \\' $DOCKERFILE_PATH

# echo "--- Dockerfile after modification ---"
# cat $DOCKERFILE_PATH
