<?php

namespace Core\Http;

class Response
{
    protected int $statusCode;
    protected array $headers = [];
    protected string $content;

    public function __construct(string $content = '', int $statusCode = 200, array $headers = [])
    {
        $this->content = $content;
        $this->statusCode = $statusCode;
        $this->headers = $headers;
    }

    public function setStatusCode(int $code): static
    {
        $this->statusCode = $code;
        return $this;
    }

    public function header(string $name, string $value): static
    {
        $this->headers[$name] = $value;
        return $this;
    }

    public static function json(mixed $data, int $statusCode = 200): static
    {
        $content = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        return new static($content ?: '', $statusCode, ['Content-Type' => 'application/json']);
    }

    public static function redirect(string $url, int $statusCode = 302): static
    {
        return new static('', $statusCode, ['Location' => $url]);
    }

    public function send(): void
    {
        http_response_code($this->statusCode);

        foreach ($this->headers as $name => $value) {
            header("{$name}: {$value}");
        }

        echo $this->content;
        exit;
    }
}
