<?php

namespace App\Repositories\UserRepository;

use PHPUnit\Framework\TestCase;
use App\Repositories\UserRepository\UserRepositoryImpl;
use App\User;
use App\Logger\LoggerInterface;
use PDO;
use Exception;

class UserRepositoryLoggerTest extends TestCase
{
    private PDO $pdo;
    private UserRepositoryImpl $repo;
    private LoggerInterface $logger;

    protected function setUp(): void
    {
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->pdo->exec("
            CREATE TABLE users (
                uuid TEXT PRIMARY KEY,
                user_name TEXT NOT NULL,
                first_name TEXT NOT NULL,
                last_name TEXT NOT NULL
            )
        ");

        // Тестовый логгер
        $this->logger = new class implements LoggerInterface {
            public array $logs = [];
            public function info(string $message): void { $this->logs[] = ['INFO', $message]; }
            public function warning(string $message): void { $this->logs[] = ['WARNING', $message]; }
        };

        $this->repo = new UserRepositoryImpl($this->pdo, $this->logger);
    }

    public function testSaveAndGetUser(): void
    {
        $user = $user = User::fromStorage('1111-1111', 'testuser', 'Test', 'User');

        $this->repo->save($user);

        $this->assertCount(1, $this->logger->logs);
        $this->assertEquals('INFO', $this->logger->logs[0][0]);
        $this->assertStringContainsString('1111-1111', $this->logger->logs[0][1]);

        $fetched = $this->repo->get('1111-1111');
        $this->assertEquals($user->getUuid(), $fetched->getUuid());
    }

    public function testGetNonExistingUserThrowsException(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Пользователь с uuid 2222-2222 не найден');

        try {
            $this->repo->get('2222-2222');
        } catch (Exception $e) {
            $this->logger->warning('Пользователь с uuid 2222-2222 не найден');
            throw $e;
        }

        $this->assertCount(1, $this->logger->logs);
        $this->assertEquals('WARNING', $this->logger->logs[0][0]);
    }
}
