<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2024-12-11 23:46:34
 */

namespace Diepxuan\DisableRegistration\Http\Middleware;

class DisableRegistrationMiddleware
{
    public function handle($request, \Closure $next)
    {
        if ($request->is('register')) {
            abort(403, 'Registration is disabled.');
        }

        return $next($request);
    }
}
