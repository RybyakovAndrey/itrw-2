<?php

namespace App;

use Ramsey\Uuid\Uuid;

class User
{
    private string $uuid;
    private string $user_name;
    private string $first_name;
    private string $last_name;

    public function __construct(string $user_name, string $first_name, string $last_name)
    {
        $this->uuid = Uuid::uuid4()->toString();
        $this->user_name = $user_name;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
    }

    public static function fromStorage(string $uuid, string $user_name, string $first_name, string $last_name): self
    {
        $obj = new self($user_name, $first_name, $last_name);
        $obj->uuid = $uuid;
        return $obj;
    }

    public function getUuid(): string {
        return $this->uuid;
    }
    public function getName(): string {
        return $this->user_name;
    }
    public function getFirstName(): string {
        return $this->first_name;
    }
    public function getLastName(): string {
        return $this->last_name;
    }
}