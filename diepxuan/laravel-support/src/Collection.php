<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2025-10-25 22:55:49
 */

namespace Diepxuan\Support;

use Illuminate\Support\Collection as BaseCollection;
use Illuminate\Support\Str;

class Collection extends BaseCollection
{
    public function toMarkdownTable(?array $headers = null, $iteration = false): string
    {
        $collection     = $this->values();
        $displayHeaders = ($iteration ? ['iteration' => ''] : []) + $headers ?? [];
        $columnWidths   = [];
        $markdown       = '';

        if ($collection->isEmpty()) {
            return '';
        }

        foreach ($collection as $iteration => $item) {
            $row = match (\gettype($item)) {
                'array' => (object) $item,
                default => $item,
            };
            foreach ($displayHeaders as $key => $headerText) {
                if ('iteration' === $key) {
                    $rawValue = "{$iteration}";
                    // $rawValue = $collection->count();
                } else {
                    $rawValue = $row->{$key} ?? null;
                }
                $stringValue = match (\gettype($rawValue)) {
                    'boolean' => $rawValue ? '1' : '0',
                    'NULL'    => '',
                    'string'  => (string) str_replace('|', '\|', $rawValue),
                    default   => (string) "{$rawValue}",
                };
                // $stringValue = Str::squish($stringValue);
                // $stringValue = vn_convert_encoding($stringValue);
                $stringValue = normalize_to_utf8($stringValue);

                $columnWidths[$key] = max(Str::of($headerText)->length(), Str::of($stringValue)->length(), $columnWidths[$key] ?? 0);
            }
        }

        $headerCells = [];
        foreach ($displayHeaders as $key => $headerText) {
            $headerCells[$key] = Str::of($headerText)->padRight($columnWidths[$key]);
        }
        $markdown .= '| ' . implode(' | ', $headerCells) . " |\n";

        $delimiterCells = [];
        foreach ($displayHeaders as $key => $headerText) {
            $delimiterCells[$key] = Str::of('')->padRight($columnWidths[$key], '-');
        }
        $markdown .= '| ' . implode(' | ', $delimiterCells) . " |\n";

        foreach ($collection as $iteration => $item) {
            $row = match (\gettype($item)) {
                'array' => (object) $item,
                default => $item,
            };
            $rowValues = [];
            foreach ($displayHeaders as $key => $headerText) {
                // foreach (array_keys($displayHeaders) as $key) {
                if ('iteration' === $key) {
                    $rawValue = "{$iteration}";
                } else {
                    $rawValue = $row->{$key} ?? null;
                }
                $stringValue = match (\gettype($rawValue)) {
                    'boolean' => $rawValue ? '1' : '0',
                    'NULL'    => '',
                    'string'  => (string) str_replace('|', '\|', $rawValue),
                    default   => (string) $rawValue,
                };
                // $stringValue = Str::squish($stringValue);
                // $stringValue = vn_convert_encoding($stringValue);
                $stringValue     = normalize_to_utf8($stringValue);
                $rowValues[$key] = match ($key) {
                    'iteration' => Str::of($stringValue)->padLeft($columnWidths[$key]),
                    'so_luong'  => Str::of($stringValue)->padLeft($columnWidths[$key]),
                    'tien_fm'   => Str::of($stringValue)->padLeft($columnWidths[$key]),
                    default     => Str::of($stringValue)->padRight($columnWidths[$key]),
                };
            }
            $markdown .= '| ' . implode(' | ', $rowValues) . " |\n";
        }

        return $markdown;
    }
}
