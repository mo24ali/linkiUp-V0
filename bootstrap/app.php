<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
<<<<<<< HEAD
        channels: __DIR__.'/../routes/channels.php', // <--- MAKE SURE THIS IS HERE
=======
        channels: __DIR__.'/../routes/channels.php',
>>>>>>> 3eb72ef463e64be5c52cb1e34670dd12a44634f5
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->append(\App\Http\Middleware\UpdateOnlineStatus::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();