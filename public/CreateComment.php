<?php

use App\Comment;
use App\Repositories\CommentRepository\CommentRepositoryInterface;
use App\Repositories\PostRepository\PostRepositoryInterface;
use App\Repositories\UserRepository\UserRepositoryInterface;
use InvalidArgumentException;

class CreateComment
{
    public function __construct(
        private CommentRepositoryInterface $commentRepository,
        private UserRepositoryInterface $userRepository,
        private PostRepositoryInterface $postRepository,
    ) {}

    public function handle(array $data): void
    {
        if (empty($data['author_uuid']) || empty($data['post_uuid']) || empty($data['text'])) {
            throw new InvalidArgumentException('Недостаточно данных');
        }

        if (
            !preg_match('/^[0-9a-fA-F\-]{36}$/', $data['author_uuid']) ||
            !preg_match('/^[0-9a-fA-F\-]{36}$/', $data['post_uuid'])
        ) {
            throw new InvalidArgumentException('Некорректный UUID');
        }

        try {
            $this->userRepository->get($data['author_uuid']);
        } catch (\Exception $e) {
            throw new InvalidArgumentException('Пользователь не найден');
        }

        try {
            $this->postRepository->get($data['post_uuid']);
        } catch (\Exception $e) {
            throw new InvalidArgumentException('Пост не найден');
        }

        $comment = Comment::create(
            $data['post_uuid'],
            $data['author_uuid'],
            $data['text']
        );

        $this->commentRepository->save($comment);
    }
}
