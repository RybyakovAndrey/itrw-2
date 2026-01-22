<?php

namespace App\Repositories\CommentRepository;

use App\Comment;
use App\Logger\Logger;
use App\Logger\LoggerInterface;
use App\Repositories\CommentRepository;
use PDO;
use Exception;

class CommentRepositoryImpl implements CommentRepositoryInterface
{
    private PDO $pdo;
    private LoggerInterface $logger;

    public function __construct(PDO $pdo, LoggerInterface $logger)
    {
        $this->pdo = $pdo;
        $this->logger = $logger;
    }

    public function save(Comment $comment): void
    {
        $statement = $this->pdo->prepare(
            'INSERT INTO comments (uuid, post_uuid, author_uuid, text)
             VALUES (:uuid, :post_uuid, :author_uuid, :text)'
        );

        $statement->execute([
            ':uuid' => $comment->getUuid(),
            ':post_uuid' => $comment->getPostUuid(),
            ':author_uuid' => $comment->getAuthorUuid(),
            ':text' => $comment->getText(),
        ]);

        $this->logger->info("Комментарий сохранён: " . $comment->getUuid());
    }

    public function delete(string $uuid): void {
        $statement = $this->pdo->prepare(
            'DELETE FROM comments WHERE uuid = :uuid'
        );
        $statement->execute([':uuid' => $uuid]);

        if ($statement->rowCount() === 0) {
            $this->logger->warning("Комментарий не найден: " . $uuid);
            throw new Exception("Комментарий с id $uuid не найден");
        }
    }

    public function get(string $uuid): Comment
    {
        $statement = $this->pdo->prepare(
            'SELECT * FROM comments WHERE uuid = :uuid'
        );

        $statement->execute([':uuid' => $uuid]);

        $data = $statement->fetch(PDO::FETCH_ASSOC);

        if ($data === false) {
            $this->logger->warning("Комментарий не найден: " . $uuid);
            throw new Exception("Нет комментария с uuid $uuid");
        }

        return Comment::fromStorage(
            $data['uuid'],
            $data['post_uuid'],
            $data['author_uuid'],
            $data['text']
        );
    }
}