<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2025-10-25 22:55:07
 */

namespace Diepxuan\Charset;

/**
 * VnEcoding.
 */
class VnEncoding extends \stdClass
{
    protected \vn_charset_conversion $converter;
    protected string $from = 'unicode';
    protected string $to   = 'ascii';

    /**
     * __construct.
     *
     * @param mixed $string
     * @param mixed $from
     * @param mixed $to
     */
    public function __construct(string $string, $from = 'unicode', $to = 'ascii')
    {
        $this->converter = new \vn_charset_conversion(normalize_to_utf8($string));
    }

    /**
     * to String.
     */
    public function __toString()
    {
        return $this->converter->convert(null, $this->from, $this->to);
    }
}
