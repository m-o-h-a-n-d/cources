<?php

namespace Core;

class Router
{
    protected array $routes = [];

    public function __construct(
        protected Container $container
    ) {
    }

    public function get(string $uri, array $action): void
    {
        $this->addRoute('GET', $uri, $action);
    }

    public function post(string $uri, array $action): void
    {
        $this->addRoute('POST', $uri, $action);
    }

    public function put(string $uri, array $action): void
    {
        $this->addRoute('PUT', $uri, $action);
    }

    public function delete(string $uri, array $action): void
    {
        $this->addRoute('DELETE', $uri, $action);
    }

    protected function addRoute(
        string $method,
        string $uri,
        array $action
    ): void {
        $this->routes[$method][$uri] = $action;
    }

    public function dispatch(string $uri, string $method)
    {
        if (! isset($this->routes[$method][$uri])) {
            http_response_code(404);
            if (function_exists('view')) {
                view('errors/404');
                return;
            }

            die('404 Not Found');
        }

        [$controller, $action] = $this->routes[$method][$uri];

      $controller = $this->container->make($controller);

        return $controller->$action();
    }
}