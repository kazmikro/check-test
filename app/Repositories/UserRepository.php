<?php

namespace App\Repositories;

use App\Contracts\DatabaseInterface;
use App\Dto\User;
use Exception;

class UserRepository
{
    public function __construct(private readonly DatabaseInterface $database)
    {
    }

    /**
     * @throws Exception
     */
    public function getUserByEmailAndPassword(string $email, string $password): ?User
    {
        $query = "
            SELECT u.id, u.name, u.email, u.created_at
            FROM users u
            WHERE u.email = :email AND u.password = :password
        ";
        $fetchResult = $this->database->fetch($query, [
            'email' => $email,
            'password' => $password,
        ]);
        if ($fetchResult === null) {
            //user not found.
            return null;
        }
        return $this->getFilledDTO($fetchResult);
    }

    /**
     * @throws Exception
     */
    private function getFilledDTO(object $object): User
    {
        return (new User())
            ->setId($object->id ?? 0)
            ->setName($object->name ?? '')
            ->setEmail($object->email ?? '')
            ->setCreatedAt(new \DateTime($object->created_at));
    }
}
