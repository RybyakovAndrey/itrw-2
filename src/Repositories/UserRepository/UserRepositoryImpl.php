<?php

namespace App\Repositories\UserRepository;

use App\User;
use App\Repositories\UserRepository;
use PDO;
use Exception;

class UserRepositoryImpl implements UserRepositoryInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(User $user): void
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO users (uuid, user_name, first_name, last_name) 
             VALUES (:uuid, :user_name, :first_name, :last_name)'
        );

        $stmt->execute([
            ':uuid' => $user->getUuid(),
            ':user_name' => $user->getName(),
            ':first_name' => $user->getFirstName(),
            ':last_name' => $user->getLastName(),
        ]);
    }

    public function get(string $uuid): User
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM users WHERE uuid = :uuid'
        );

        $stmt->execute([':uuid' => $uuid]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data === false) {
            throw new Exception("Пользователь с uuid $uuid не найден");
        }

        return User::fromStorage(
            $data['uuid'],
            $data['user_name'],
            $data['first_name'],
            $data['last_name']
        );
    }
}
