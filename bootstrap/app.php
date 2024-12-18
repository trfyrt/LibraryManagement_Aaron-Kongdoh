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
        
        $middleware->alias([
            'admin' => \App\Http\Middleware\Admin::class,
            'librarian' => \App\Http\Middleware\Librarian::class,
            'student' => \App\Http\Middleware\Student::class,
            'general' => \App\Http\Middleware\General::class,
            'lecturer' => \App\Http\Middleware\Lecturer::class,

        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
