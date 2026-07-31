<?php

namespace Core;

use App\Providers\ServiceProvider;
use Core\Config\ConfigLoader;
use Core\Config\ConfigManager;
use Core\Environment\EnvLoader;
use Core\Http\Kernel;

class Application
{
    protected ConfigManager $config;

    protected Container $container;

    /**
     * @var ServiceProvider[]
     */
    protected array $providers = [];

    public function __construct()
    {
        $this->loadEnvironment();

        $this->loadConfiguration();

        $this->loadContainer();

        $this->startSession();

        $this->registerProviders();

        $this->bootProviders();
    }

    protected function loadEnvironment(): void
    {
        $loader = new EnvLoader();

        $loader->load(
            base_path('.env')
        );
    }

    protected function loadConfiguration(): void
    {
        $loader = new ConfigLoader();

        $configs = $loader->load(
            base_path('config')
        );

        $this->config = new ConfigManager($configs);
    }

    protected function loadContainer(): void
    {
        $this->container = new Container();
    }

    protected function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    protected function registerProviders(): void
    {
        $providers = $this->config->get('app.providers', []);

        foreach ($providers as $providerClass) {

            /** @var ServiceProvider $provider */
            $provider = new $providerClass(
                $this->container,
                $this->config
            );

            $provider->register();

            $this->providers[] = $provider;
        }
    }

    protected function bootProviders(): void
    {
        foreach ($this->providers as $provider) {
            $provider->boot();
        }
    }

    public function config(): ConfigManager
    {
        return $this->config;
    }

    public function container(): Container
    {
        return $this->container;
    }

    public function handleRequest(): void
    {
        $kernel = new Kernel($this);
    
        $kernel->handle();
    }

   
}