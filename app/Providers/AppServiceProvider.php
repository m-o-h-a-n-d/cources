<?php  


namespace App\Providers;

use App\Providers\ServiceProvider;
use Core\Config\ConfigManager;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register application services here
        $this->container->instance(
            ConfigManager::class,
            $this->config
        );

    }

    public function boot()
    {
        // Bootstrapping application services here
    }
}