<?php

namespace App\Controllers;

use App\Contracts\{RenderInterface, RequestInterface, Services\UserServiceInterface};
use App\SimpleValidator;
use App\Attributes\{Get, Post};

class UserController extends BaseController
{
    public function __construct(
        private readonly RenderInterface $template,
        private readonly UserServiceInterface $userService,
        private readonly RequestInterface $request
    ) {
    }

    public function beforeAction(): void
    {
        parent::beforeAction();
        if ($this->userService->isLoggedIn()) {
            $this->redirect('/');
        }
    }

    #[Get('/login')]
    #[Post('/login')]
    public function login(): string
    {
        if ($this->request->isPost()) {
            $email = $this->request->post('email');
            $password = $this->request->post('password');

            $validator = new SimpleValidator();
            $validator
                ->setName('email')->setValue($email)->email()->max(320)
                ->setName('password')->setValue($password)->min(6);
            $errors = $validator->getErrors();

            if ($validator->isValid()) {
                $result = $this->userService->login($email, $password);
                if ($result) {
                    $this->redirect('/');
                } else {
                    $errors['login'] = 'Incorrect login or password.';
                }
            }
        }

        return $this->template->render('login.twig', [
            'errors' => $errors ?? [],
        ]);
    }

    #[Get('/logout')]
    public function logout(): void
    {
        $this->userService->logout();
        $this->redirect('/');
    }
}
