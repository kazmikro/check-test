<?php

namespace App\Dto;

class Article
{
    private int $id;
    private int $userId;
    private string $title;
    private string $text;
    private string $userName;
    private string $userEmail;
    private \DateTime $createdAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Article
    {
        $this->id = $id;
        return $this;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): Article
    {
        $this->userId = $userId;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): Article
    {
        $this->title = $title;
        return $this;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): Article
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->userName;
    }

    /**
     * @param string $userName
     * @return Article
     */
    public function setUserName(string $userName): Article
    {
        $this->userName = $userName;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserEmail(): string
    {
        return $this->userEmail;
    }

    /**
     * @param string $userEmail
     * @return Article
     */
    public function setUserEmail(string $userEmail): Article
    {
        $this->userEmail = $userEmail;
        return $this;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): Article
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}
