<?php

namespace App\Contracts;

interface RequestInterface
{
    public function isPost(): bool;

    public function get(string $key, mixed $default_value = null): mixed;

    public function post(string $key, mixed $default_value = null): mixed;

    public function isMethod(string $method): bool;
}
