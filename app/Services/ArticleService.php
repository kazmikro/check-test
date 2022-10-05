<?php

namespace App\Services;

use App\Contracts\Services\{ArticleServiceInterface, UserServiceInterface};
use App\Dto\Article;
use App\Repositories\ArticleRepository;
use Exception;

class ArticleService implements ArticleServiceInterface
{
    public function __construct(
        private readonly ArticleRepository $articleRepository,
        private readonly UserServiceInterface $userService
    ) {
    }

    public function create(string $title, string $text): bool
    {
        $userId = $this->userService->getCurrentUserId();
        return $this->articleRepository->createPost($userId, $title, $text);
    }

    /**
     * @throws Exception
     */
    public function getById(int $id): ?Article
    {
        return $this->articleRepository->getArticleById($id);
    }

    /**
     * @return array<Article>
     * @throws Exception
     */
    public function getList(int $limit, int $offset = 0, int $userId = 0): array
    {
        return $this->articleRepository->getList($limit, $offset, $userId);
    }
}
