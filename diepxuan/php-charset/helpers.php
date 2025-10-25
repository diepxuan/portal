<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2025-10-25 22:54:44
 */

use Diepxuan\Charset\VnEncoding;

if (!function_exists('vn_convert_encoding')) {
    /**
     * Convert Vietnamese encoding to another.
     *
     * @param mixed $string
     * @param mixed $from
     * @param mixed $to
     */
    function vn_convert_encoding(string $string, $from = 'unicode', $to = 'ascii'): string
    {
        try {
            return (string) new VnEncoding($string, $from, $to);
        } catch (Throwable $th) {
            return '';
        }
    }
}

if (!function_exists('normalize_to_utf8')) {
    function normalize_to_utf8($text)
    {
        // Nếu null hoặc trống thì trả luôn
        if (empty($text)) {
            return $text;
        }

        // Chuyển sang UTF-8 chuẩn
        if (!mb_check_encoding($text, 'UTF-8')) {
            $text = iconv('WINDOWS-1258', 'UTF-8//IGNORE', $text);
        }

        // Chuẩn hóa dạng Unicode tổ hợp → dựng sẵn
        $text = Normalizer::normalize($text, Normalizer::FORM_C);

        // Fix lỗi ký tự lạ
        return preg_replace('/[\x00-\x1F\x7F]/u', '', $text);
        // Tự động phát hiện mã
        // $encoding = mb_detect_encoding($text, ['UTF-8', 'WINDOWS-1258', 'WINDOWS-1252', 'ISO-8859-1', 'ISO-8859-2', 'VNI', 'TCVN3'], true);
        $encoding = mb_detect_encoding($text, mb_detect_order(), true);

        if ('UTF-8' !== $encoding) {
            $text = iconv($encoding ?: 'CP1258', 'UTF-8//IGNORE', $text);
        }

        return $text;
    }
}
