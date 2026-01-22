<?php

namespace App\Repositories\PostRepository;

use PHPUnit\Framework\TestCase;
use App\Post;
use App\Logger\LoggerInterface;
use PDO;
use Exception;

class PostRepositoryLoggerTest extends TestCase
{
    private PDO $pdo;
    private PostRepositoryImpl $repo;
    private LoggerInterface $logger;

    protected function setUp(): void
    {
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->pdo->exec("
            CREATE TABLE posts (
                uuid TEXT PRIMARY KEY,
                author_uuid TEXT NOT NULL,
                title TEXT NOT NULL,
                text TEXT NOT NULL
            )
        ");

        // Тестовый логгер
        $this->logger = new class implements LoggerInterface {
            public array $logs = [];
            public function info(string $message): void { $this->logs[] = ['INFO', $message]; }
            public function warning(string $message): void { $this->logs[] = ['WARNING', $message]; }
        };

        $this->repo = new PostRepositoryImpl($this->pdo, $this->logger);
    }

    public function testSaveAndGetPost(): void
    {
        $post = Post::fromStorage('1111-1111', 'author-uuid', 'Test Title', 'Test text');

        $this->repo->save($post);

        // Проверяем лог сохранения
        $this->assertCount(1, $this->logger->logs);
        $this->assertEquals('INFO', $this->logger->logs[0][0]);
        $this->assertStringContainsString($post->getUuid(), $this->logger->logs[0][1]);

        $fetched = $this->repo->get('1111-1111');
        $this->assertEquals($post->getUuid(), $fetched->getUuid());
        $this->assertEquals($post->getTitle(), $fetched->getTitle());
    }

    public function testGetNonExistingPostThrowsException(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Пост с uuid 2222-2222 не найден');

        try {
            $this->repo->get('2222-2222');
        } catch (Exception $e) {
            $this->logger->warning('Пост не найден: 2222-2222');
            throw $e;
        }

        $this->assertCount(1, $this->logger->logs);
        $this->assertEquals('WARNING', $this->logger->logs[0][0]);
    }

    public function testDeletePost(): void
    {
        $post = Post::fromStorage('3333-3333', 'author-uuid', 'Title', 'Text');
        $this->repo->save($post);

        $this->repo->delete('3333-3333');

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Пост с uuid 3333-3333 не найден');
        $this->repo->get('3333-3333');
    }

    public function testDeleteNonExistingPostThrowsException(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Пост с uuid 4444-4444 не найден');

        try {
            $this->repo->delete('4444-4444');
        } catch (Exception $e) {
            $this->logger->warning('Пост не найден: 4444-4444');
            throw $e;
        }

        $this->assertCount(1, $this->logger->logs);
        $this->assertEquals('WARNING', $this->logger->logs[0][0]);
    }
}
