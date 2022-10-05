<?php

namespace App\Repositories;

use App\Contracts\DatabaseInterface;
use App\Dto\Article;
use Exception;

class ArticleRepository
{
    public function __construct(private readonly DatabaseInterface $database)
    {
    }

    /**
     * @throws Exception
     */
    public function getList(int $limit, int $offset = 0, int $userId = 0): array
    {
        $queryParams = [
            'limit' => $limit,
            'offset' => $offset,
        ];
        $where = '';
        if ($userId) {
            $where = 'WHERE a.user_id = :userId';
            $queryParams['userId'] = $userId;
        }
        $query = "
            SELECT a.id, a.user_id as userId, a.title, a.text, a.created_at, u.name as userName, u.email as userEmail
            FROM articles a
            INNER JOIN users u ON u.id = a.user_id
            {$where}
            ORDER BY a.created_at DESC
            LIMIT :offset, :limit
        ";
        $fetchResult = $this->database->fetchAll($query, $queryParams);
        if (empty($fetchResult)) {
            return [];
        }
        $result = [];
        foreach ($fetchResult as $article) {
            $result[] = $this->getFilledDTO($article);
        }
        return $result;
    }

    public function createPost(int $userId, string $title, string $text): bool
    {
        return $this->database->execute(
            "
                INSERT INTO articles (user_id, title, text, created_at)
                VALUES (:user_id, :title, :text, :created_at)
            ",
            [
                ':user_id' => $userId,
                ':title' => $title,
                ':text' => $text,
                ':created_at' => date('Y-m-d H:i:s'),
            ]
        );
    }

    /**
     * @throws Exception
     */
    public function getArticleById(int $id): ?Article
    {
        $query = "
            SELECT a.id, a.user_id as userId, a.title, a.text, a.created_at, u.name as userName, u.email as userEmail
            FROM articles a
            INNER JOIN users u ON u.id = a.user_id
            WHERE a.id = :id
        ";
        $fetchResult = $this->database->fetch($query, [
            'id' => $id,
        ]);
        if ($fetchResult === null) {
            return null;
        }
        return $this->getFilledDTO($fetchResult);
    }

    /**
     * @throws Exception
     */
    private function getFilledDTO(object $object): Article
    {
        return (new Article())
            ->setId($object->id ?? 0)
            ->setUserId($object->userId ?? 0)
            ->setTitle($object->title ?? '')
            ->setText($object->text ?? '')
            ->setCreatedAt(new \DateTime($object->created_at))
            ->setUserName($object->userName ?? '')
            ->setUserEmail($object->userEmail ?? '');
    }
}
