{ pkgs }:
let
  phpRuntime = (pkgs.php82.buildEnv {
    # extraConfig = ''
    #   extension=sqlsrv.so
    #   extension=pdo_sqlsrv.so
    # '';
    extensions = ({ enabled, all }: enabled ++ (with all; [
      pdo
      sqlsrv
      pdo_sqlsrv
      # mysql
      pdo_mysql

      # include other extensions you need here, e.g., pdo_mysql
      # Thêm các extension bạn cần
      gd # Thường cần cho xử lý ảnh
      intl # Cần cho internationalization
      zip # Composer thường cần
      openssl # Đã có sẵn nhưng ghi rõ cũng tốt
      bcmath # Laravel thường cần
      exif # Laravel thường cần
      sockets # Laravel thường cần
      # vips       # Nếu bạn dùng Laravel Vips
      dom
      imagick
      opcache
      soap
      xsl
      mbstring
    ]));
  });
  pkgs-with-unfree = import pkgs.path {
    # Giữ nguyên hệ thống hiện tại
    inherit (pkgs) system;
    # Đây là chìa khóa: Cho phép các gói có license không tự do
    config.allowUnfree = true;
  };
  # unixODBC-with-mssql = pkgs.unixODBC.override {
  #   odbcDrivers = [
  #     pkgs.unixODBCDrivers.msodbcsql18
  #   ];
  # };
  # Sử dụng `pkgs.runCommand` để tạo một package mới chứa các file config
  odbc-config = pkgs.runCommand "odbc-config-files" { } ''
    # Bước 1: Tìm đường dẫn driver một cách an toàn
    # Dùng `set -e` để script thoát ngay khi có lỗi
    set -e
    echo "Finding ODBC driver..."
    DRIVER_PATH=$(find ${pkgs.unixODBCDrivers.msodbcsql18}/lib -name "libmsodbcsql-*.so.*" | head -n 1)

    # Kiểm tra nếu không tìm thấy
    if [ -z "$DRIVER_PATH" ]; then
      echo "FATAL: Driver .so file not found!"
      exit 1
    fi
    echo "Driver found at: $DRIVER_PATH"

    # Bước 2: Tạo thư mục output và file config
    mkdir -p $out/etc
    CONFIG_FILE="$out/etc/odbcinst.ini"
    echo "Creating config file at: $CONFIG_FILE"

    # Bước 3: Ghi vào file config với cú pháp heredoc chính xác
    # Chú ý: `EOF` ở cuối phải nằm ở đầu dòng, không có khoảng trắng.
    cat > "$CONFIG_FILE" <<EOF
    [ODBC Driver 18 for SQL Server]
    Description=Microsoft ODBC Driver 18 for SQL Server
    Driver=$DRIVER_PATH
    EOF
    # <<-- Dòng trống này quan trọng để đảm bảo EOF không bị lỗi

    echo "Config file created successfully."
  ''; # <-- Kết thúc chuỗi script
in
{
  channel = "stable-24.11";
  # channel = "unstable";

  # Bật Docker daemon
  services.docker.enable = true;

  packages = [
    pkgs.nodejs_20
    # pkgs.php
    phpRuntime
    pkgs.php82Packages.composer
    pkgs.php82Packages.php-cs-fixer
    # pkgs-with-unfree.php84Extensions.sqlsrv
    # pkgs-with-unfree.php84Extensions.pdo_sqlsrv
    pkgs.openssl
    pkgs.libjpeg
    pkgs.libpng
    pkgs.vips # xử lý ảnh
    pkgs.git
    # pkgs.mariadb
    pkgs.mariadb-client

    # pkgs.cloudflared
    pkgs.foreman
    pkgs.docker
    pkgs.docker-client # Thêm Docker CLI để có thể tương tác
    pkgs.docker-compose # Rất hữu ích nếu bạn muốn quản lý nhiều container

    # --- Drivers và Thư viện Hệ thống sqlsrv ---
    pkgs.unixODBC
    pkgs.unixODBCDrivers.msodbcsql17
    odbc-config
    # --- DRIVERS & LIBRARIES ---
    # Đây là cách gọi override an toàn nhất
    # Chúng ta override package unixODBC bằng một attribute set mới
    # (pkgs.unixODBC.override {
    #   # Thuộc tính `odbcDrivers` nhận một danh sách các package driver
    #   odbcDrivers = [ 
    #     # Sử dụng package driver chính thức, không phải từ unixODBCDrivers
    #     pkgs.unixODBCDrivers.msodbcsql18 
    #   
    # })
    # unixODBC-with-mssql
    # pkgs-with-unfree.unixODBC                     # Trình quản lý ODBC, msodbcsql18 phụ thuộc vào nó
    # pkgs-with-unfree.unixODBCDrivers.msodbcsql18  # Microsoft ODBC Driver for SQL Server (version 18)
    # pkgs.msodbcsql18
  ];
  idx.extensions = [
    "svelte.svelte-vscode"
    "vue.volar"
    "ms-vscode.sublime-keybindings"
    "junstyle.php-cs-fixer"
    "foxundermoon.shell-format"
  ];
  idx.previews = {
    enable = true;
    previews = {
      web = {
        command = [
          "foreman"
          "start"
          "-f"
          "Procfile"
        ];
        manager = "web";
        env = {
          PORT = "$PORT";
        };
      };
      # web = {
      #   command = [
      #     "php"
      #     "artisan"
      #     "serve"
      #     "--port"
      #     "$PORT"
      #     "--host"
      #     "0.0.0.0"
      #   ];
      #   manager = "web";
      # };
    };
  };

  idx.workspace = {
    onCreate = {
      npm-install = "npm install";
      composer-install = "composer install";
    };
    onStart = {
      setup-odbc-env = ''
        echo 'export ODBCSYSINI=${odbc-config}/etc' >> $HOME/.bashrc
        echo 'export LD_LIBRARY_PATH="${pkgs.unixODBCDrivers.msodbcsql18}/lib:${pkgs.unixODBC}/lib:$LD_LIBRARY_PATH"' >> $HOME/.bashrc
      '';
      # foreman = "foreman start -f Procfile";
      # npm-dev = "npm run dev";
      # mysql-demon = "${pkgs.cloudflared}/bin/cloudflared access tcp --hostname mysql.diepxuan.io.vn --url 127.0.0.1:3306";
      # sql-demon = "${pkgs.cloudflared}/bin/cloudflared access tcp --hostname sql.diepxuan.io.vn --url 0.0.0.0:1433";
      # log-laravel = "tail -f storage/logs/laravel.log";

      # php-server = "php artisan serve";
      # npm-watch-fe = "npm run watch:frontend";
    };
  };
}
