<?php

namespace App\Providers;

use App\Helpers\Menu\Contracts\MenuProvider as MenuProviderInterface;
use App\Helpers\Menu\MenuProvider;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Modules\Admin\Models\Admin;
use Modules\Customer\Models\Customer;

/**
 * Class AppServiceProvider
 *
 * Application service provider.
 */
class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(MenuProviderInterface::class, fn () => new MenuProvider([]));
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Request::macro('guard', fn (): string => Str::after(
            Arr::first(
                $this->route()->gatherMiddleware(),
                fn ($middleware) => Str::startsWith($middleware, 'auth:'),
            ),
            'auth:',
        ));

        Request::macro('guestGuard', fn (): ?string => Str::after(
            Arr::first(
                $this->route()->gatherMiddleware(),
                fn ($middleware) => Str::startsWith($middleware, 'guest:'),
            ),
            'guest:',
        ));

        Request::macro('guestRedirectionRoute', function (): string {
            return match ($this->guard()) {
                'admin' => URL::route('guest.auth.admin.login'),
                'customer' => URL::route('guest.auth.customer.login'),
                default => URL::route('landing'),
            };
        });

        Request::macro('usersRedirectionRoute', function (): string {
            return match ($this->guestGuard()) {
                'admin' => URL::route('admin.dashboard'),
                'customer' => URL::route('customer.dashboard'),
                default => match (Auth::user()::class) {
                    Admin::class => URL::route('admin.dashboard'),
                    Customer::class => URL::route('customer.dashboard'),
                    default => URL::route('landing'),
                },
            };
        });

        Gate::guessPolicyNamesUsing(function ($class, ?string $userClass = null) {
            $classDirname = str_replace('/', '\\', dirname(str_replace('\\', '/', $class)));

            $classDirnameSegments = explode('\\', $classDirname);

            $userBaseClass = $userClass ? class_basename($userClass) : null;

            $className = Collection::times(count($classDirnameSegments))
                ->map(fn ($index) => implode('\\', array_filter([...array_slice($classDirnameSegments, 0, $index), 'Policies', $userBaseClass, class_basename($class) . 'Policy'])))
                ->last(fn ($class) => class_exists($class));

            return [$className ?: ($classDirname . '\\Policies\\' . class_basename($class) . 'Policy')];
        });
    }
}
