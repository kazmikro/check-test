<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Attributes\Get;
use App\Contracts\{RenderInterface, RequestInterface, Services\ArticleServiceInterface};

class IndexController extends BaseController
{
    public function __construct(
        private readonly RenderInterface $template,
        private readonly ArticleServiceInterface $articleService,
        private readonly RequestInterface $request
    ) {
    }

    #[Get('/')]
    public function index(): string
    {
        $userId = (int)$this->request->get('author_id', 0);
        return $this->template->render('articles/list.twig', [
            'articles' => $this->articleService->getList(limit: 3, userId: $userId),
        ]);
    }
}
