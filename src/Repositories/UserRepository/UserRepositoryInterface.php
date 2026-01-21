<?php

namespace App\Repositories\UserRepository;

use App\User;

interface UserRepositoryInterface
{
    public function get(string $uuid): User;

    public function save(User $user): void;
}
