<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2025-05-24 16:53:25
 */

namespace Diepxuan\Catalog\Services;

use Illuminate\Support\Facades\Auth;

class CatalogService
{
    public function user()
    {
        return Auth::user();
    }

    public function simbaUser()
    {
        return $this->user()->getSimbaUser();
    }
}
