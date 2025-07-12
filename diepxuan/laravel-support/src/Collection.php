<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2025-07-12 23:00:45
 */

namespace Diepxuan\Support;

use Illuminate\Support\Collection as BaseCollection;
use Illuminate\Support\Str;

class Collection extends BaseCollection
{
    public function toMarkdownTable(?array $headers = null, $iteration = false): string
    {
        $collection     = $this;
        $displayHeaders = ($iteration ? ['iteration' => ''] : []) + $headers ?? [];
        $columnWidths   = [];
        $markdown       = '';

        if ($collection->isEmpty()) {
            return '';
        }

        $columnWidths = collect($displayHeaders)
            ->map(static function ($headerText, $key) use ($collection) {
                if ('iteration' === $key) {
                    $rawValue       = $collection->count();
                    $rawValueLength = Str::of("{$rawValue}")->length();
                } else {
                    $rawValueLength = $collection
                        ->max(static function ($item) use ($key) {
                            $item = match (\gettype($item)) {
                                'array' => (object) $item,
                                default => $item,
                            };

                            return Str::of($item->{$key} ?? null)->length();
                        })
                    ;
                }

                return max(Str::of($headerText)->length(), $rawValueLength);
            })
        ;

        $markdownHeader = collect($displayHeaders)
            ->map(static fn ($headerText, $key) => Str::of($headerText)->padRight($columnWidths[$key]))
            ->implode(' | ')
        ;
        $markdown .= "| {$markdownHeader} |\n";

        $markdownDelimiter = collect($displayHeaders)
            ->map(static fn ($headerText, $key) => Str::of('')->padRight($columnWidths[$key], '-'))
            ->implode(' | ')
        ;
        $markdown .= "| {$markdownDelimiter} |\n";

        $markdownContent = $collection->values()
            ->map(static function ($item, $iteration) use ($displayHeaders, $columnWidths) {
                $row = match (\gettype($item)) {
                    'array' => (object) $item,
                    default => $item,
                };
                $rowValues = collect($displayHeaders)
                    ->map(static function ($headerText, $key) use ($iteration, $row, $columnWidths) {
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
                        $stringValue = Str::squish($stringValue);

                        return Str::of($stringValue)->padRight($columnWidths[$key]);
                    })
                    ->implode(' | ')
                ;

                return "| {$rowValues} |";
            })
            ->implode("\n")
        ;
        $markdown .= "{$markdownContent}";

        return $markdown;
    }
}
