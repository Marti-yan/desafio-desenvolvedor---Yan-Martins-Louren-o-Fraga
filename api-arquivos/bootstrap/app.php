<?php

ini_set('post_max_size', '500M');
ini_set('upload_max_filesize', '500M');
ini_set('max_execution_time', '300'); 

use App\Http\Middleware\ForceJsonResponse;
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
    ->withMiddleware(function (Middleware $middleware): void {
        //
        $middleware->prependToGroup(
            'api',
            [ForceJsonResponse::class]
        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();


