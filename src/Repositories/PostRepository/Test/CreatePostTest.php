<?php

namespace App\Repositories\PostRepository\Test;

use PDO;
use PHPUnit\Framework\TestCase;
use App\Post;
use App\Repositories\PostRepository\PostRepositoryImpl;

class CreatePostTest extends TestCase
{
    private PDO $pdo;
    private PostRepositoryImpl $repo;

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

        $this->repo = new PostRepositoryImpl($this->pdo);
    }

    public function testCreatePostSuccess(): void
    {
        $post = Post::create('author-1', 'Заголовок', 'Текст статьи');
        $this->repo->save($post);

        $fetched = $this->repo->get($post->getUuid());

        $this->assertSame($post->getUuid(), $fetched->getUuid());
        $this->assertSame($post->getTitle(), $fetched->getTitle());
    }

    public function testCreatePostInvalidUuid(): void
    {
        $this->expectException(Exception::class);
        $this->repo->get('invalid-uuid');
    }

    public function testCreatePostMissingData(): void
    {
        $this->expectException(TypeError::class); // конструктор Post требует 3 параметра
        $post = new Post('author-1', 'Заголовок');
    }
}
