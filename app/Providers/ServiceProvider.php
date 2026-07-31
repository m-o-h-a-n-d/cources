<?php  


namespace App\Providers;

use Core\Config\ConfigManager;
use Core\Container;

abstract class ServiceProvider
{
     public function __construct(
        protected Container $container,
        protected ConfigManager $config
    ) {
    }

    abstract public function register() ; 


    public function boot()
    {
        // Bootstrapping application services here
    }
}