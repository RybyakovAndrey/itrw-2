<?php

namespace App;

use Ramsey\Uuid\Uuid;

class Post
{
    private string $uuid;
    private string $author_uuid;
    private string $title;
    private string $text;
    public function __construct(string $author_uuid, string $title, string $text)
    {
        $this->uuid = Uuid::uuid4()->toString();;
        $this->author_uuid = $author_uuid;
        $this->title = $title;
        $this->text = $text;
    }

    public function getUuid(): string {
        return $this->uuid;
    }
    public function getAuthorUuid(): string {
        return $this->author_uuid;
    }
    public function getTitle(): string {
        return $this->title;
    }
    public function getText(): string {
        return $this->text;
    }
}