<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2024-12-11 23:32:30
 */

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

date_default_timezone_set('Asia/Ho_Chi_Minh');
$config = import_url('https://raw.githubusercontent.com/diepxuan/php/main/.php-cs-fixer.dist.php');
$config = str_replace('<?php', '', $config);

return eval($config);
