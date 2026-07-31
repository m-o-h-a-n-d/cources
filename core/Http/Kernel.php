<?php

namespace Core\Http;

use Core\Application;
use Core\Router;

class Kernel
{
    public function __construct(
        protected Application $app
    ) {
    }

    public function handle(): void
    {
        /** @var Router $router */
        $router = $this->app
            ->container()
            ->make(Router::class);

        if (file_exists(base_path('routers/web.php'))) {
            require base_path('routers/web.php');
        }

       $uri = $_SERVER['PATH_INFO']
    ?? preg_replace(
        '#^/index\.php#',
        '',
        parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH)
    );

$uri = $uri ?: '/';
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

        $router->dispatch($uri, $method);
    }
}