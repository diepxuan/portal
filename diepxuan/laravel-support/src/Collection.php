<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2025-07-08 14:13:44
 */

namespace Diepxuan\Support;

use Illuminate\Support\Collection as BaseCollection;

class Collection extends BaseCollection
{
    public function toMarkdownTable(?array $headers = null): string
    {
        $collection     = $this;
        $displayHeaders = $headers ?? [];
        $columnWidths   = [];
        $markdown       = '';

        if ($collection->isEmpty()) {
            return '';
        }

        // foreach ($displayHeaders as $key => $headerText) {
        //     $columnWidths[$key] = mb_strlen($headerText, 'UTF-8');
        // }

        foreach ($collection as $item) {
            $row = match (\gettype($item)) {
                'array' => (object) $item,
                default => $item,
            };
            foreach ($displayHeaders as $key => $headerText) {
                $rawValue           = $row->{$key} ?? '';
                $columnWidths[$key] = max(mb_strlen($headerText, 'UTF-8'), mb_strlen($rawValue, 'UTF-8'), $columnWidths[$key] ?? 0);
            }
        }

        $padString = static function (string $string, int $length, int $padType = STR_PAD_RIGHT) use (&$padString) {
            $stringLength = mb_strlen($string, 'UTF-8');
            $padding      = $length - $stringLength;
            if ($padding <= 0) {
                return $string;
            }

            return (STR_PAD_LEFT === $padType ? str_repeat(' ', $padding) : '')
                . $string
                . (STR_PAD_RIGHT === $padType ? str_repeat(' ', $padding) : '');
        };

        $headerCells = [];
        foreach ($displayHeaders as $key => $headerText) {
            $headerCells[$key] = $padString($headerText, $columnWidths[$key]);
        }
        $markdown .= '| ' . implode(' | ', $headerCells) . " |\n";

        $delimiterCells = [];
        foreach ($displayHeaders as $key => $headerText) {
            $delimiterCells[$key] = str_repeat('-', $columnWidths[$key]);
        }
        $markdown .= '| ' . implode(' | ', $delimiterCells) . " |\n";

        foreach ($collection as $item) {
            $row = match (\gettype($item)) {
                'array' => (object) $item,
                default => $item,
            };
            $rowValues = [];
            foreach (array_keys($displayHeaders) as $key) {
                $rawValue = $row->{$key} ?? null;

                $stringValue = match (\gettype($rawValue)) {
                    'boolean' => $rawValue ? '1' : '0',
                    'NULL'    => '',
                    'string'  => (string) str_replace('|', '\|', $rawValue),
                    default   => (string) $rawValue,
                };
                $rowValues[$key] = $padString($stringValue, $columnWidths[$key]);
            }
            $markdown .= '| ' . implode(' | ', $rowValues) . " |\n";
        }

        return $markdown;
    }
}
