<?php

namespace App\Repositories\PostRepository;

use App\Logger\LoggerInterface;
use App\Post;
use App\Repositories\PostRepository;
use PDO;
use Exception;

class PostRepositoryImpl implements PostRepositoryInterface
{
    private PDO $pdo;
    private LoggerInterface $logger;

    public function __construct(PDO $pdo, LoggerInterface $logger)
    {
        $this->pdo = $pdo;
        $this->logger = $logger;
    }

    public function delete(string $uuid): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM posts WHERE uuid = :uuid');
        $stmt->execute([':uuid' => $uuid]);

        if ($stmt->rowCount() === 0) {
            $this->logger->warning('Пост не найден: ' . $uuid);
            throw new Exception("Пост с uuid $uuid не найден");
        }
    }

    public function save(Post $post): void
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO posts (uuid, author_uuid, title, text) 
             VALUES (:uuid, :author_uuid, :title, :text)'
        );

        $stmt->execute([
            ':uuid' => $post->getUuid(),
            ':author_uuid' => $post->getAuthorUuid(),
            ':title' => $post->getTitle(),
            ':text' => $post->getText(),
        ]);

        $this->logger->info("Пост сохранён: " . $post->getUuid());
    }

    public function get(string $uuid): Post
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM posts WHERE uuid = :uuid'
        );

        $stmt->execute([':uuid' => $uuid]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data === false) {
            $this->logger->warning("Пост не найден: " . $uuid);
            throw new Exception("Пост с uuid $uuid не найден");
        }

        return Post::fromStorage(
            $data['uuid'],
            $data['author_uuid'],
            $data['title'],
            $data['text']
        );
    }
}
