<?php

declare(strict_types=1);

namespace App\Contracts;

interface RenderInterface
{
    public function render(string $name, array $context = []): string;
}
