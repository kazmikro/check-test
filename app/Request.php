<?php

namespace App;

use App\Contracts\RequestInterface;
use App\Enums\HttpMethod;

class Request implements RequestInterface
{
    private string $method = '';

    public function __construct(
        private readonly array $get,
        private readonly array $post,
        private readonly array $server
    ) {
    }

    public function isMethod(string $method): bool
    {
        return $this->getMethod() === strtoupper($method);
    }

    public function isPost(): bool
    {
        return $this->getMethod() === HttpMethod::POST;
    }

    public function get(string $key, mixed $default_value = null): mixed
    {
        return $this->get[$key] ?? $default_value;
    }

    public function post(string $key, mixed $default_value = null): mixed
    {
        return $this->post[$key] ?? $default_value;
    }

    private function getMethod(): string
    {
        if (!empty($this->method)) {
            return $this->method;
        }
        return $this->server['REQUEST_METHOD'] ?? HttpMethod::GET;
    }
}
