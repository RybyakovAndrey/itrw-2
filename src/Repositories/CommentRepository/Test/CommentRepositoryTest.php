<?php

namespace App\Repositories\CommentRepository\Test;

use PHPUnit\Framework\TestCase;
use App\Comment;
use App\Repositories\CommentRepository\CommentRepositoryImpl;
use PDO;

class CommentRepositoryTest extends TestCase
{
    private \PDO $pdo;
    private CommentRepositoryImpl $repo;

    protected function setUp(): void
    {
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // создаём таблицу
        $this->pdo->exec(
            "CREATE TABLE comments (
                uuid TEXT PRIMARY KEY,
                post_uuid TEXT NOT NULL,
                author_uuid TEXT NOT NULL,
                text TEXT NOT NULL
            )"
        );

        $this->repo = new CommentRepositoryImpl($this->pdo);
    }

    public function testSaveAndGetComment(): void
    {
        $comment = Comment::create('post-1', 'author-1', 'Текст комментария');
        $this->repo->save($comment);

        $fetched = $this->repo->get($comment->getUuid());

        $this->assertSame($comment->getUuid(), $fetched->getUuid());
        $this->assertSame($comment->getPostUuid(), $fetched->getPostUuid());
        $this->assertSame($comment->getAuthorUuid(), $fetched->getAuthorUuid());
        $this->assertSame($comment->getText(), $fetched->getText());
    }

    public function testGetNonExistentCommentThrowsException(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessageMatches('/Нет комментария с uuid/');
        $this->repo->get('non-existent-uuid');
    }
}
