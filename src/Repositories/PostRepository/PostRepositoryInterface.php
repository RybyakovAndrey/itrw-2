<?php

namespace App\Repositories\PostRepository;

use App\Post;

interface PostRepositoryInterface
{
    public function get(string $uuid): Post;
    public function delete(string $uuid): bool;
    public function save(Post $post): void;
}