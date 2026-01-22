<?php

use App\Repositories\PostRepository\PostRepositoryInterface;
use InvalidArgumentException;
use Exception;

class DeletePost
{
    public function __construct(
        private PostRepositoryInterface $postRepository
    ) {}

    public function handle(string $uuid): void
    {
        if (!preg_match('/^[0-9a-fA-F\-]{36}$/', $uuid)) {
            throw new InvalidArgumentException('Некорректный UUID');
        }

        try {
            $this->postRepository->delete($uuid);
        } catch (Exception $e) {
            throw new InvalidArgumentException('Пост не найден');
        }
    }
}
