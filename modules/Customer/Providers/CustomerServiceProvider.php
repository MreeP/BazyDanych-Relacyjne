<?php

namespace Modules\Customer\Providers;

use App\Providers\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Livewire\Livewire;
use Modules\Customer\Livewire\Profile\Edit as ProfileEdit;

/**
 * Class CustomerServiceProvider
 *
 * Service provider for the Customer module.
 */
class CustomerServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../Config/customer.php', 'customer');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->customerMenuEntry('customer.dashboard', 'Dashboard', 'heroicon-o-home', 'customer.dashboard');

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/web/routes.php');
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'Customer');

        Blade::anonymousComponentPath(__DIR__ . '/../Resources/Components', 'customer');
        Blade::componentNamespace('Modules\\Customer\\View\\Components', 'customer');

        foreach ($this->livewireComponents() as $name => $class) {
            Livewire::component($name, $class);
        }
    }

    /**
     * Get the Livewire components for the module.
     *
     * @return string[]
     */
    private function livewireComponents(): array
    {
        return [
            'customer.profile.edit' => ProfileEdit::class,
        ];
    }
}
