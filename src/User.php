<?php

namespace App;

class User
{
    private int $user_id;
    private string $firstName;
    private string $lastName;

    public function __construct(int $user_id, string $firstName, string $lastName)
    {
        $this->$user_id = $user_id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }
}