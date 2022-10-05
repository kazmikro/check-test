<?php

namespace App\Services;

use App\Contracts\Services\UserServiceInterface;
use App\Repositories\UserRepository;
use Exception;

class UserService implements UserServiceInterface
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    /**
     * @param string $email
     * @param string $password
     * @return bool
     * @throws Exception
     */
    public function login(string $email, string $password): bool
    {
        $user = $this->userRepository->getUserByEmailAndPassword($email, md5($password));
        if ($user === null) {
            return false;
        }
        $_SESSION['userId'] = $user->getId();
        return true;
    }

    public function getCurrentUserId(): int
    {
        return $_SESSION['userId'] ?? 0;
    }

    public function logout(): void
    {
        $_SESSION['userId'] = null;
    }

    public static function isLoggedIn(): bool
    {
        return !empty($_SESSION['userId']);
    }
}
