<?php

namespace Core;

class Router
{
    protected array $routes = [];

    protected array $groupMiddlewares = [];

    public function __construct(
        protected Container $container
    ) {
    }

    public function get(
        string $uri,
        array $action,
        array $middlewares = []
    ): void {
        $this->addRoute(
            'GET',
            $uri,
            $action,
            $middlewares
        );
    }

    public function post(
        string $uri,
        array $action,
        array $middlewares = []
    ): void {
        $this->addRoute(
            'POST',
            $uri,
            $action,
            $middlewares
        );
    }

    public function put(
        string $uri,
        array $action,
        array $middlewares = []
    ): void {
        $this->addRoute(
            'PUT',
            $uri,
            $action,
            $middlewares
        );
    }

    public function delete(
        string $uri,
        array $action,
        array $middlewares = []
    ): void {
        $this->addRoute(
            'DELETE',
            $uri,
            $action,
            $middlewares
        );
    }

    protected function addRoute(
        string $method,
        string $uri,
        array $action,
        array $middlewares = []
    ): void {
        $middlewares = array_merge(
            $this->groupMiddlewares,
            $middlewares
        );

        $this->routes[$method][$uri] = [
            'action' => $action,
            'middlewares' => $middlewares,
        ];
    }

    public function middleware(
        string|array $middlewares
    ): self {
        $this->groupMiddlewares = (array) $middlewares;

        return $this;
    }

    public function group(
        callable $callback
    ): void {
        $callback($this);

        $this->groupMiddlewares = [];
    }

    public function dispatch(
        string $uri,
        string $method
    ) {
        if (!isset($this->routes[$method][$uri])) {
            http_response_code(404);

            if (function_exists('view')) {
                view('errors/404');
                return;
            }

            die('404 Not Found');
        }

        $route = $this->routes[$method][$uri];

        foreach ($route['middlewares'] as $middleware) {
            $instance = $this->container->make(
                $middleware
            );

            $instance->handle();
        }

        [$controller, $action] = $route['action'];

        $controller = $this->container->make(
            $controller
        );

        return $controller->$action();
    }
}