<?php

namespace App;

class User
{
    private string $uuid;
    private string $user_name;
    private string $first_name;
    private string $last_name;

    public function __construct(string $uuid, string $user_name, string $first_name, string $last_name)
    {
        $this->uuid = $uuid;
        $this->user_name = $user_name;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
    }
}