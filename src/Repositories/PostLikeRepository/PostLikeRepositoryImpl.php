<?php

namespace App\Repositories\PostLikeRepository;

use App\PostLike;
use PDO;

class PostLikeRepositoryImpl implements PostLikeRepositoryInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
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
    }

    public function getByPostUuid(string $post_uuid): array
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM post_likes WHERE post_uuid = :post_uuid
        ");

        $stmt->execute([':post_uuid' => $post_uuid]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $likes = [];
        foreach ($rows as $row) {
            $likes[] = PostLike::fromStorage($row['uuid'], $row['post_uuid'], $row['user_uuid']);
        }
        return $likes;
    }
}
