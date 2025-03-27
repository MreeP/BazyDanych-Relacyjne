<?php

namespace Modules\Admin\Providers;

use App\Providers\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Livewire\Livewire;
use Modules\Admin\Livewire\Profile\Edit as ProfileEdit;

/**
 * Class AdminServiceProvider
 *
 * Service provider for the Admin module.
 */
class AdminServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../Config/admin.php', 'admin');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->adminMenuEntry('admin.dashboard', 'Dashboard', 'heroicon-o-home', 'admin.dashboard');

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/web/routes.php');
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'Admin');

        Blade::anonymousComponentPath(__DIR__ . '/../Resources/Components', 'admin');
        Blade::componentNamespace('Modules\\Admin\\View\\Components', 'admin');

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
            'admin.profile.edit' => ProfileEdit::class,
        ];
    }
}
