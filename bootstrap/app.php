<?php

use App\Auth\Access\MultiGuardGate;
use App\Console\PrepareEnvironmentForTesting;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withCommands([
        PrepareEnvironmentForTesting::class,
    ])
    ->withSingletons([
        Gate::class => MultiGuardGate::containerConcreteResolver(),
    ])
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/50d052cb-e3a0-402a-ba36-176720867a6b',
    )
    ->withExceptions(function (Exceptions $exceptions) {})
    ->withMiddleware(function (Middleware $middleware) {
        $middleware
            ->web(append: [
                AddLinkHeadersForPreloadedAssets::class,
            ])
            ->redirectTo(
                guests: fn (Request $request) => $request->guestRedirectionRoute(),
                users: fn (Request $request) => $request->usersRedirectionRoute(),
            );
    })
    ->create();
