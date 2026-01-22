<?php

namespace App\Repositories\CommentRepository;

use PHPUnit\Framework\TestCase;
use App\Comment;
use App\Logger\LoggerInterface;
use PDO;
use Exception;

class CommentRepositoryLoggerTest extends TestCase
{
    private PDO $pdo;
    private CommentRepositoryImpl $repo;
    private LoggerInterface $logger;

    protected function setUp(): void
    {
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->pdo->exec("
            CREATE TABLE comments (
                uuid TEXT PRIMARY KEY,
                post_uuid TEXT NOT NULL,
                author_uuid TEXT NOT NULL,
                text TEXT NOT NULL
            )
        ");

        $this->logger = new class implements LoggerInterface {
            public array $logs = [];
            public function info(string $message): void { $this->logs[] = ['INFO', $message]; }
            public function warning(string $message): void { $this->logs[] = ['WARNING', $message]; }
        };

        $this->repo = new CommentRepositoryImpl($this->pdo, $this->logger);
    }

    public function testSaveAndGetComment(): void
    {
        $comment = Comment::fromStorage(
            '1111-1111',
            'post-uuid',
            'user-uuid',
            'Тестовый комментарий'
        );

        $this->repo->save($comment);

        $this->assertCount(1, $this->logger->logs);
        $this->assertEquals('INFO', $this->logger->logs[0][0]);
        $this->assertStringContainsString($comment->getUuid(), $this->logger->logs[0][1]);

        $fetched = $this->repo->get('1111-1111');
        $this->assertEquals($comment->getUuid(), $fetched->getUuid());
        $this->assertEquals($comment->getText(), $fetched->getText());
    }

    public function testGetNonExistingCommentThrowsException(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Нет комментария с uuid 2222-2222');

        try {
            $this->repo->get('2222-2222');
        } catch (Exception $e) {
            $this->logger->warning('Комментарий не найден: 2222-2222');
            throw $e;
        }

        $this->assertCount(1, $this->logger->logs);
        $this->assertEquals('WARNING', $this->logger->logs[0][0]);
        $this->assertStringContainsString('2222-2222', $this->logger->logs[0][1]);
    }

    public function testDeleteCommentLogsWarning(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Комментарий с id 3333-3333 не найден');

        try {
            $this->repo->delete('3333-3333');
        } catch (Exception $e) {
            $this->logger->warning('Комментарий не найден: 3333-3333');
            throw $e;
        }

        $this->assertCount(1, $this->logger->logs);
        $this->assertEquals('WARNING', $this->logger->logs[0][0]);
    }
}
