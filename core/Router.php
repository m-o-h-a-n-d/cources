<?php

namespace Core;

class Router
{
    protected array $routes = [];
    protected array $groupMiddlewares = [];

    public function __construct(protected Container $container)
    {
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

    public function middleware(string $middleware): static
    {
        $this->groupMiddlewares[] = $middleware;
        return $this;
    }

    protected function addRoute(string $method, string $uri, array $action): void
    {
        $normalizedUri = '/' . trim($uri, '/');
        if ($normalizedUri !== '/' && str_ends_with($normalizedUri, '/')) {
            $normalizedUri = rtrim($normalizedUri, '/');
        }

        $this->routes[$method][$normalizedUri] = [
            'action' => $action,
            'middlewares' => $this->groupMiddlewares,
        ];
    }

    public function group(callable $callback): void
    {
        $callback($this);
        $this->groupMiddlewares = [];
    }

    public function dispatch(
        string $uri,
        string $method
    ) {
        $normalizedUri = '/' . trim($uri, '/');
        if ($normalizedUri !== '/' && str_ends_with($normalizedUri, '/')) {
            $normalizedUri = rtrim($normalizedUri, '/');
        }

        if (!isset($this->routes[$method][$normalizedUri])) {
            http_response_code(404);

            if (function_exists('view')) {
                view('errors/404');
                return;
            }

            die('404 Not Found');
        }

        $route = $this->routes[$method][$normalizedUri];

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