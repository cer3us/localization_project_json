<?php

use App\Exceptions\Account\InvalidUserCredentialsException;
use App\Exceptions\Account\NoAccessToOperationException;
use App\Exceptions\Project\InvalidLanguageException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->api(prepend: [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api'
        ]);

        $middleware->alias([
            'document.add.access' => \App\Http\Middleware\Document\AddDocumentAccessMiddleware::class,
            'document.list.access' => \App\Http\Middleware\Document\GetDocumentMiddleware::class,
            'document.access' => \App\Http\Middleware\Document\DocumentAccessMiddleware::class,
            'project.lang' => \App\Http\Middleware\Project\CheckProjectTargetLangMiddleware::class,
            'project.access' => \App\Http\Middleware\Project\ProjectAccessMiddleware::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->renderable(function (InvalidUserCredentialsException $e) {
            return response()->json([
                'status' => 'failed',
                'message' => __("exceptions.{$e->getMessage()}")
            ], 401);
        });

        $exceptions->renderable(function (NoAccessToOperationException $e) {
            return response()->json([
                'status' => 'failed',
                'message' => __("exceptions.{$e->getMessage()}")
            ], 403);
        });

        $exceptions->renderable(function (InvalidLanguageException $e) {
            return response()->json([
                'status' => 'failed',
                'message' => __("exceptions.{$e->getMessage()}")
            ], 400);
        });
    })->create();
