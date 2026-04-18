# Đường dẫn đến Dockerfile gốc trong vendor
DOCKERFILE_PATH=${1:-"./vendor/laravel/sail/runtimes/8.2/Dockerfile"}
DOCKERFILE_SQLSRV=${2:-"./vendor/laravel/sail/runtimes/8.2/Dockerfile_sqlsrv"}

# HTTP to HTTPS conversion block
HTTPS_FIX=$(
    cat <<'EOF'
# Convert ALL HTTP to HTTPS for Ubuntu repositories (firewall blocks port 80)
# Must modify sources.list BEFORE apt-get update
RUN sed -i 's|http://archive.ubuntu.com|https://archive.ubuntu.com|g' /etc/apt/sources.list && \
    sed -i 's|http://security.ubuntu.com|https://security.ubuntu.com|g' /etc/apt/sources.list

EOF
)

SQLSRV_INSTALL=$(
    cat <<EOF
    && curl -sSL -O https://packages.microsoft.com/config/ubuntu/\$(grep VERSION_ID /etc/os-release | cut -d '"' -f 2)/packages-microsoft-prod.deb \\
    && dpkg -i packages-microsoft-prod.deb \\
    && rm packages-microsoft-prod.deb \\
    && apt-get update \\
    && ACCEPT_EULA=Y apt-get install -y msodbcsql18 \\
    && ACCEPT_EULA=Y apt-get install -y mssql-tools18 \\
    && apt-get install -y unixodbc-dev \\

EOF
)

PHPSQLSRV_INSTALL=$(
    cat <<EOF
    && pecl install sqlsrv \\
    && pecl install pdo_sqlsrv \\
    && printf "; priority=20\nextension=sqlsrv.so\n" > /etc/php/8.2/mods-available/sqlsrv.ini \\
    && printf "; priority=30\nextension=pdo_sqlsrv.so\n" > /etc/php/8.2/mods-available/pdo_sqlsrv.ini \\
    && phpenmod sqlsrv pdo_sqlsrv \\
EOF
)

# echo "--- Dockerfile before modification ---"
# cat $DOCKERFILE_PATH
# ORIGINAL_CONTENT=$(cat "$DOCKERFILE_PATH")

HTTPS_INSERTED=false

while IFS= read -r line; do
    echo "$line"

    # Insert HTTPS fix AFTER timezone setup, BEFORE apt-get update
    if [[ "$HTTPS_INSERTED" == "false" && "$line" == *"ENV SUPERVISOR_PHP_COMMAND="* ]]; then
        echo ""
        echo "$HTTPS_FIX"
        HTTPS_INSERTED=true
    fi

    # Insert SQLSRV packages after postgresql-client install
    if [[ "$line" == *"&& apt-get install -y postgresql-client-"* ]]; then
        echo "$SQLSRV_INSTALL"
        echo "$PHPSQLSRV_INSTALL"
    fi
done <"$DOCKERFILE_PATH" >"$DOCKERFILE_SQLSRV"
