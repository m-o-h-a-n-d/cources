<?php

namespace Core;

use Core\Config\ConfigLoader;
use Core\Config\ConfigManager;
use Core\Environment\EnvLoader;
use App\Repository\StudentRepositoryInterface;
use App\Repository\StudentRepository;

class Application
{
    protected ConfigManager $config;

    protected Container $container;

    public function __construct()
    {
        $this->loadEnvironment();

        $this->loadConfiguration();

        $this->loadContainer();

        $this->registerCoreServices();
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

    protected function registerCoreServices(): void
    {
        $this->container->instance(
            ConfigManager::class,
            $this->config
        );

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $dbConfig = $this->config->get('database');
        if ($dbConfig) {
            $db = new Database($dbConfig);
            $this->container->instance(Database::class, $db);

            if (class_exists(Model::class)) {
                Model::setConnection($db->connection());
            }
        }

        $this->container->bind(
            StudentRepositoryInterface::class,
            StudentRepository::class
        );

        $this->container->instance(
            Router::class,
            new Router($this->container)
        );
    }

    public function config(): ConfigManager
    {
        return $this->config;
    }

    public function container(): Container
    {
        return $this->container;
    }

    public function run(): void
    {
        /** @var Router $router */
        $router = $this->container->make(Router::class);

        if (file_exists(base_path('routers/web.php'))) {
            require base_path('routers/web.php');
        }

        $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

        $router->dispatch($uri, $method);
    }
}
