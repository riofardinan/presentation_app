<?php

use Illuminate\Foundation\Application;
use App\Http\Middleware\AuthMiddleware;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(StartSession::class);
        $middleware->append(VerifyCsrfToken::class);
        // $middleware->append(AuthMiddleware::class);
        $middleware->append(ShareErrorsFromSession::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
