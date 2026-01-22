<?php

use App\PostLike;
use App\Repositories\PostLikeRepository\PostLikeRepositoryInterface;
use App\Repositories\PostRepository\PostRepositoryInterface;
use App\Repositories\UserRepository\UserRepositoryInterface;
use InvalidArgumentException;

class CreatePostLike
{
    public function __construct(
        private PostLikeRepositoryInterface $likeRepository,
        private UserRepositoryInterface $userRepository,
        private PostRepositoryInterface $postRepository,
    ) {}

    public function handle(array $data): void
    {
        if (empty($data['user_uuid']) || empty($data['post_uuid'])) {
            throw new InvalidArgumentException('Недостаточно данных');
        }

        if (
            !preg_match('/^[0-9a-fA-F\-]{36}$/', $data['user_uuid']) ||
            !preg_match('/^[0-9a-fA-F\-]{36}$/', $data['post_uuid'])
        ) {
            throw new InvalidArgumentException('Некорректный UUID');
        }

        try {
            $this->userRepository->get($data['user_uuid']);
        } catch (\Exception $e) {
            throw new InvalidArgumentException('Пользователь не найден');
        }

        try {
            $this->postRepository->get($data['post_uuid']);
        } catch (\Exception $e) {
            throw new InvalidArgumentException('Пост не найден');
        }

        $existingLikes = $this->likeRepository->getByPostUuid($data['post_uuid']);
        foreach ($existingLikes as $like) {
            if ($like->getUserUuid() === $data['user_uuid']) {
                throw new InvalidArgumentException('Пользователь уже поставил лайк этому посту');
            }
        }

        // Создаем лайк
        $like = PostLike::create($data['post_uuid'], $data['user_uuid']);
        $this->likeRepository->save($like);
    }
}
