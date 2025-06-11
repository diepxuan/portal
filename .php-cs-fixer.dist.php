<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2025-06-05 15:10:49
 */

date_default_timezone_set('Asia/Ho_Chi_Minh');

if (!function_exists('import_url')) {
    function import_url($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }
}

$cacheFile = __DIR__ . '/.php-cs-fixer.cache.php';
$sourceUrl = 'https://raw.githubusercontent.com/diepxuan/php/main/.php-cs-fixer.dist.php';
$expire    = 3_600 * 24; // Cache 1 ngày

// Nếu chưa có cache hoặc cache hết hạn
if (!file_exists($cacheFile) || time() - filemtime($cacheFile) > $expire) {
    $config = import_url($sourceUrl);
    file_put_contents($cacheFile, "{$config}");
    // $config = str_replace('<?php', '', $config);
    // file_put_contents($cacheFile, "<?php\n{$config}");
}

return require $cacheFile;
// return eval($config);
