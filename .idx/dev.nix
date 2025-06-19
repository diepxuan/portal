{ pkgs }: {
  channel = "stable-24.11";
  # channel = "unstable";

  # Bật Docker daemon
  services.docker.enable = true;

  packages = [
    pkgs.nodejs_20
    pkgs.php
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

  ];
  idx.extensions = [
    "svelte.svelte-vscode"
    "vue.volar"
    "ms-vscode.sublime-keybindings"
    "junstyle.php-cs-fixer"
    "foxundermoon.shell-format"
    "esbenp.prettier-vscode"
    "rexshi.phpdoc-comment-vscode-plugin"
    "EditorConfig.EditorConfig"
    "dawidd6.debian-vscode"
    "redhat.vscode-xml"
    "laravel.vscode-laravel"
    "shufo.vscode-blade-formatter"
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
    };
  };

  idx.workspace = {
    onCreate = {
      npm-install = "npm install";
      composer-install = "composer install";
    };
    onStart = { };
  };
}
