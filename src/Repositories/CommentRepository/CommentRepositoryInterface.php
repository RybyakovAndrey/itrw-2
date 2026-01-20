<?php

namespace App\Repositories\CommentRepository;

use App\Comment;

interface CommentRepositoryInterface
{
    public function get(string $uuid): Comment;

    public function save(Comment $comment): void;
}