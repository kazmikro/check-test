<?php

namespace App\Controllers;

use App\SimpleValidator;
use Exception;
use App\Contracts\{RenderInterface, RequestInterface, Services\ArticleServiceInterface, Services\UserServiceInterface};
use App\Exceptions\PageNotFoundException;
use App\Attributes\{Get, Post};

class ArticleController extends BaseController
{
    public function __construct(
        private readonly RenderInterface $template,
        private readonly ArticleServiceInterface $articleService,
        private readonly UserServiceInterface $userService,
        private readonly RequestInterface $request
    ) {
    }

    /**
     * @throws PageNotFoundException
     * @throws Exception
     */
    #[Post('/articles/create')]
    #[Get('/articles/create')]
    public function create(): string
    {
        if (!$this->userService->getCurrentUserId()) {
            throw new PageNotFoundException();
        }

        if ($this->request->isPost()) {
            $title = $this->request->post('title');
            $text = $this->request->post('text');

            $validator = new SimpleValidator();
            $validator
                ->setName('title')->setValue($title)->min(3)->max(255)
                ->setName('text')->setValue($text)->min(6);

            $errors = $validator->getErrors();

            if ($validator->isValid()) {
                $result = $this->articleService->create($title, $text);
                if ($result) {
                    $this->redirect('/');
                } else {
                    $errors['create_error'] = 'Error during create the post. Please try again later.';
                }
            }
        }

        return $this->template->render('articles/create.twig', [
            'errors' => $errors ?? [],
        ]);
    }

    /**
     * @throws PageNotFoundException
     */
    #[Get('/article/')]
    public function getById(): string
    {
        $id = (int)$this->request->get('id');
        if (!$id) {
            throw new PageNotFoundException();
        }
        $article = $this->articleService->getById($id);
        if (!$article) {
            throw new PageNotFoundException();
        }
        return $this->template->render('articles/id.twig', [
            'article' => $article,
        ]);
    }
}
