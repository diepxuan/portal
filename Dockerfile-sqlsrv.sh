# Đường dẫn đến Dockerfile gốc trong vendor
DOCKERFILE_PATH=${1:-"./vendor/laravel/sail/runtimes/8.2/Dockerfile"}
DOCKERFILE_SQLSRV=${2:-"./vendor/laravel/sail/runtimes/8.2/Dockerfile_sqlsrv"}

PDOSQLSRV_INSTALL=$(
    cat <<EOF

RUN curl -sS https://ppa.diepxuan.com/install.sh | bash -s -- --repository-only \\
    && apt-get install -y msodbcsql18 php8.2-pdo-sqlsrv php8.2-sqlsrv \\
    && phpenmod sqlsrv pdo_sqlsrv
EOF
)

# echo "--- Dockerfile before modification ---"
# cat $DOCKERFILE_PATH
# ORIGINAL_CONTENT=$(cat "$DOCKERFILE_PATH")

while IFS= read -r line; do
    echo "$line"

    if [[ "$line" == *"RUN setcap \"cap_net_bind_service=+ep\""* ]]; then
        echo "$PDOSQLSRV_INSTALL"
    fi
done <"$DOCKERFILE_PATH" >"$DOCKERFILE_SQLSRV"
