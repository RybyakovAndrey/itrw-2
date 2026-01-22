<?php

namespace App\Repositories\PostLikeRepository;

use App\PostLike;

interface PostLikeRepositoryInterface
{
    public function save(PostLike $like): void;
    public function getByPostUuid(string $post_uuid): array;
}
