<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Diepxuan\Support\Http\Middleware\SessionDomain;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->validateCsrfTokens(['simba/si/vch/year/select']);
        // Cookie session/XSRF theo host: Portal chay tren ca
        // portaldev.diepxuan.io.vn, portal.diepxuan.corp va portal.diepxuan.io.vn.
        $middleware->append(SessionDomain::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
