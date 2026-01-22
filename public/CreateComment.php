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
        // Проверка всех данных
        if (empty($data['author_uuid']) || empty($data['post_uuid']) || empty($data['text'])) {
            throw new InvalidArgumentException('Недостаточно данных');
        }

        // Проверка формата UUID
        if (
            !preg_match('/^[0-9a-fA-F\-]{36}$/', $data['author_uuid']) ||
            !preg_match('/^[0-9a-fA-F\-]{36}$/', $data['post_uuid'])
        ) {
            throw new InvalidArgumentException('Некорректный UUID');
        }

        // Проверка существования пользователя
        try {
            $this->userRepository->get($data['author_uuid']);
        } catch (\Exception $e) {
            throw new InvalidArgumentException('Пользователь не найден');
        }

        // Проверка существования поста
        try {
            $this->postRepository->get($data['post_uuid']);
        } catch (\Exception $e) {
            throw new InvalidArgumentException('Пост не найден');
        }

        // Создаём комментарий
        $comment = Comment::create(
            $data['post_uuid'],
            $data['author_uuid'],
            $data['text']
        );

        // Сохраняем комментарий
        $this->commentRepository->save($comment);
    }
}
