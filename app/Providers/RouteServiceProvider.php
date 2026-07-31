<?php  


namespace App\Providers;

use App\Providers\ServiceProvider;
use Core\Router;

class RouteServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->container->instance(
            Router::class,
            new Router($this->container)
        );
    }

    public function boot():void 
    {
        // Bootstrapping application services here
    }
}