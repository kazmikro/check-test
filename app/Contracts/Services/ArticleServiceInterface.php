<?php

namespace App\Contracts\Services;

use App\Dto\Article;

interface ArticleServiceInterface
{
    public function create(string $title, string $text): bool;

    public function getById(int $id): ?Article;

    public function getList(int $limit, int $offset = 0, int $userId = 0): array;

}
