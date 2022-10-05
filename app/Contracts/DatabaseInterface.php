<?php

declare(strict_types=1);

namespace App\Contracts;

interface DatabaseInterface
{
    public function fetch(string $query, array $parameters = []): ?object;

    public function fetchAll(string $query, array $parameters = []): array;

    public function execute(string $query, array $parameters = []): bool;
}
