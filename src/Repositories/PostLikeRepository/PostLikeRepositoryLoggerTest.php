<?php

namespace App\Repositories\PostLikeRepository;

use PHPUnit\Framework\TestCase;
use App\PostLike;
use App\Logger\LoggerInterface;
use PDO;

class PostLikeRepositoryLoggerTest extends TestCase
{
    private PDO $pdo;
    private PostLikeRepositoryImpl $repo;
    private LoggerInterface $logger;

    protected function setUp(): void
    {
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->pdo->exec("
            CREATE TABLE post_likes (
                uuid TEXT PRIMARY KEY,
                post_uuid TEXT NOT NULL,
                user_uuid TEXT NOT NULL
            )
        ");

        $this->logger = new class implements LoggerInterface {
            public array $logs = [];
            public function info(string $message): void { $this->logs[] = ['INFO', $message]; }
            public function warning(string $message): void { $this->logs[] = ['WARNING', $message]; }
        };

        $this->repo = new PostLikeRepositoryImpl($this->pdo, $this->logger);
    }

    public function testSaveAndGetLikes(): void
    {
        $like = PostLike::fromStorage('1111-1111', 'post-uuid', 'user-uuid');

        $this->repo->save($like);

        $this->assertCount(1, $this->logger->logs);
        $this->assertEquals('INFO', $this->logger->logs[0][0]);
        $this->assertStringContainsString($like->getUuid(), $this->logger->logs[0][1]);

        $likes = $this->repo->getByPostUuid('post-uuid');
        $this->assertCount(1, $likes);
        $this->assertEquals('1111-1111', $likes[0]->getUuid());
    }

    public function testGetByPostUuidNoLikesLogsWarning(): void
    {
        $likes = $this->repo->getByPostUuid('non-existing-post');
        $this->assertEmpty($likes);

        $this->assertCount(1, $this->logger->logs);
        $this->assertEquals('WARNING', $this->logger->logs[0][0]);
        $this->assertStringContainsString('non-existing-post', $this->logger->logs[0][1]);
    }
}
