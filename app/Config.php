<?php

declare(strict_types=1);

namespace App;

/**
 * @property-read ?array $db
 */
class Config
{
    protected array $config = [];

    public function __construct(array $env)
    {
        $this->config = [
            'db' => [
                'host' => $env['DB_HOST'] ?? '127.0.0.1',
                'user' => $env['DB_USER'] ?? 'root',
                'password' => $env['DB_PASS'] ?? '',
                'dbname' => $env['DB_DATABASE'] ?? 'check24',
                'charset' => $env['DB_CHARSET'] ?? 'utf8',
            ],
        ];
    }

    public function __get(string $name)
    {
        return $this->config[$name] ?? null;
    }
}
