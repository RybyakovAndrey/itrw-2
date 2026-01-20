<?php

namespace App\Repositories\PostRepository\Test;

use PHPUnit\Framework\TestCase;
use App\Post;
use App\Repositories\PostRepository\PostRepositoryImpl;
use \PDO;
use \Exception;

class PostRepositoryTest extends TestCase
{
    private PDO $pdo;
    private PostRepositoryImpl $repo;

    protected function setUp(): void
    {
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->pdo->exec(
            "CREATE TABLE posts (
                uuid TEXT PRIMARY KEY,
                author_uuid TEXT NOT NULL,
                title TEXT NOT NULL,
                text TEXT NOT NULL
            )"
        );

        $this->repo = new PostRepositoryImpl($this->pdo);
    }

    public function testSaveAndGetPost(): void
    {
        $post = Post::create('author-1', 'Заголовок', 'Текст поста');
        $this->repo->save($post);

        $fetched = $this->repo->get($post->getUuid());

        $this->assertSame($post->getUuid(), $fetched->getUuid());
        $this->assertSame($post->getAuthorUuid(), $fetched->getAuthorUuid());
        $this->assertSame($post->getTitle(), $fetched->getTitle());
        $this->assertSame($post->getText(), $fetched->getText());
    }

    public function testGetNonExistentPostThrowsException(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessageMatches('/Пост с uuid/');
        $this->repo->get('non-existent-uuid');
    }
}
