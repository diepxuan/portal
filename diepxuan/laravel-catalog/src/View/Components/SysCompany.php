<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2025-06-04 10:25:11
 */

namespace Diepxuan\Catalog\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

// <x-catalog::sys-company>
class SysCompany extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): string|View
    {
        $company = \CatalogService::company();
        // \Debugbar::info($company);

        return <<<HTML
                <span>[ {$company->ma_cty} ]</span>
                <span class="text-sm font-bold">{$company->ten_cty}</span>
            HTML;
    }
}
