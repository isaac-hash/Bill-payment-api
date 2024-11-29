<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->group('api', [
            \Laravel\Passport\Http\Middleware\CheckClientCredentials::class, // Passport client credentials check
            'throttle:api',  // Throttle API requests
            \Illuminate\Routing\Middleware\SubstituteBindings::class,  // Bind route parameters
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
