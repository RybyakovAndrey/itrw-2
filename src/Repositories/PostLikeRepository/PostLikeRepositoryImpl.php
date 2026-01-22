<?php

namespace App\Repositories\PostLikeRepository;

use App\Logger\LoggerInterface;
use App\PostLike;
use PDO;

class PostLikeRepositoryImpl implements PostLikeRepositoryInterface
{
    private PDO $pdo;
    private LoggerInterface $logger;

    public function __construct(PDO $pdo, LoggerInterface $logger)
    {
        $this->pdo = $pdo;
        $this->logger = $logger;
    }

    public function save(PostLike $like): void
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO post_likes (uuid, post_uuid, user_uuid) 
            VALUES (:uuid, :post_uuid, :user_uuid)
        ");

        $stmt->execute([
            ':uuid' => $like->getUuid(),
            ':post_uuid' => $like->getPostUuid(),
            ':user_uuid' => $like->getUserUuid()
        ]);

        $this->logger->info("Лайк поста сохранён: " . $like->getUuid());
    }

    public function getByPostUuid(string $post_uuid): array
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM post_likes WHERE post_uuid = :post_uuid
        ");

        $stmt->execute([':post_uuid' => $post_uuid]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($rows)) {
            $this->logger->warning("Нет лайка на посту: " . $post_uuid);
        }

        $likes = [];
        foreach ($rows as $row) {
            $likes[] = PostLike::fromStorage($row['uuid'], $row['post_uuid'], $row['user_uuid']);
        }
        return $likes;
    }
}
