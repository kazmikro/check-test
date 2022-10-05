<?php

namespace App\Contracts\Services;

interface UserServiceInterface
{
    public function login(string $email, string $password): bool;

    public function getCurrentUserId(): int;

    public function logout(): void;

    public static function isLoggedIn(): bool;
}
