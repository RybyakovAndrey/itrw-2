<?php

namespace App\Repositories\CommentRepository;

use App\Comment;

interface CommentRepositoryInterface
{
    public function get(string $uuid): Comment;
    public function delete(string $uuid): void;
    public function save(Comment $comment): void;
}