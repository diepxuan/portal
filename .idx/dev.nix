{pkgs}: {
  channel = "stable-23.11";
  packages = [
    pkgs.nodejs_20
    pkgs.php
    pkgs.php82Packages.composer
    pkgs.openssl
    pkgs.libjpeg
    pkgs.libpng
    pkgs.vips              # xử lý ảnh
    pkgs.git
    pkgs.cloudflared
  ];
  idx.extensions = [
    "svelte.svelte-vscode"
    "vue.volar"
    "ms-vscode.sublime-keybindings"
  ];
  idx.previews = {
    enable=true;
    previews = {
      web = {
        command = [
          "php"
          "artisan"
          "serve"
          "--port"
          "$PORT"
          "--host"
          "0.0.0.0"
        ];
        manager = "web";
        # Preview cổng 8000
        # port = 8000;
      };
    };
  };

  idx.workspace = {
    onCreate = {
      npm-install = "npm install";
      composer-install = "composer install";
    };
    onStart = {
      # npm-watch-fe = "npm run watch:frontend";
      npm-dev = "npm run dev";
      mysql-demon = "${pkgs.cloudflared}/bin/cloudflared access tcp --hostname mysql.diepxuan.io.vn --url 127.0.0.1:3306";
      sql-demon = "${pkgs.cloudflared}/bin/cloudflared access tcp --hostname sql.diepxuan.io.vn --url 127.0.0.1:1433";
      # php-server = "php artisan serve";
      log-laravel = "tail -f storage/logs/laravel.log";
    };
  };
}