<?php

namespace App;

use Ramsey\Uuid\Uuid;

class PostLike
{
    private string $uuid;
    private string $post_uuid;
    private string $user_uuid;

    public function __construct(string $uuid, string $post_uuid, string $user_uuid)
    {
        $this->uuid = $uuid;
        $this->post_uuid = $post_uuid;
        $this->user_uuid = $user_uuid;
    }

    public static function create(string $post_uuid, string $user_uuid): self
    {
        return new self(Uuid::uuid4()->toString(), $post_uuid, $user_uuid);
    }

    public static function fromStorage(string $uuid, string $post_uuid, string $user_uuid): self
    {
        return new self($uuid, $post_uuid, $user_uuid);
    }

    public function getUuid(): string { return $this->uuid; }
    public function getPostUuid(): string { return $this->post_uuid; }
    public function getUserUuid(): string { return $this->user_uuid; }
}
