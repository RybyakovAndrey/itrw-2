<?php

namespace App;

use Ramsey\Uuid\Uuid;

class Comment
{
    private string $uuid;
    private string $post_uuid;
    private string $author_uuid;
    private string $text;
    public function __construct(string $uuid, string $post_uuid, string $author_uuid, string $text){
        $this->uuid = $uuid;
        $this->post_uuid = $post_uuid;
        $this->author_uuid = $author_uuid;
        $this->text = $text;
    }

    public static function create(string $post_uuid, string $author_uuid, string $text): self
    {
        return new self(Uuid::uuid4()->toString(), $post_uuid, $author_uuid, $text);
    }

    public static function fromStorage(string $uuid, string $post_uuid, string $author_uuid, string $text): self
    {
        return new self($uuid, $post_uuid, $author_uuid, $text);
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getPostUuid(): string
    {
        return $this->post_uuid;
    }

    public function getAuthorUuid(): string
    {
        return $this->author_uuid;
    }

    public function getText(): string
    {
        return $this->text;
    }
}