<?php

namespace Core\Http;

use Core\Validator;

class Request
{
    protected array $get;
    protected array $post;
    protected array $files;
    protected array $server;

    public function __construct(array $get = [], array $post = [], array $files = [], array $server = [])
    {
        $this->get = $get ?: $_GET;
        $this->post = $post ?: $_POST;
        $this->files = $files ?: $_FILES;
        $this->server = $server ?: $_SERVER;
    }

    public static function capture(): static
    {
        return new static($_GET, $_POST, $_FILES, $_SERVER);
    }

    public function uri(): string
    {
        $uri = $this->server['REQUEST_URI'] ?? '/';
        return parse_url($uri, PHP_URL_PATH) ?: '/';
    }

    public function method(): string
    {
        return strtoupper($this->server['REQUEST_METHOD'] ?? 'GET');
    }

    public function isMethod(string $method): bool
    {
        return $this->method() === strtoupper($method);
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->get[$key] ?? $default;
    }

    public function post(string $key, mixed $default = null): mixed
    {
        return $this->post[$key] ?? $default;
    }

    public function input(string $key, mixed $default = null): mixed
    {
        return $this->post[$key] ?? $this->get[$key] ?? $default;
    }

    public function file(string $key): mixed
    {
        return $this->files[$key] ?? null;
    }

    public function all(): array
    {
        return array_merge($this->get, $this->post);
    }

    /**
     * Validate incoming request parameters.
     */
    public function validate(array $rules, array $messages = []): Validator
    {
        return Validator::make($this->all(), $rules, $messages);
    }
}
