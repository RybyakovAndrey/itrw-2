<?php

namespace App;

use Ramsey\Uuid\Uuid;

class Post
{
    private string $uuid;
    private string $author_uuid;
    private string $title;
    private string $text;

    private function __construct(string $uuid, string $author_uuid, string $title, string $text)
    {
        $this->uuid = $uuid;
        $this->author_uuid = $author_uuid;
        $this->title = $title;
        $this->text = $text;
    }

    public static function create(string $author_uuid, string $title, string $text): self
    {
        return new self(Uuid::uuid4()->toString(), $author_uuid, $title, $text);
    }

    public static function fromStorage(string $uuid, string $author_uuid, string $title, string $text): self
    {
        return new self($uuid, $author_uuid, $title, $text);
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
