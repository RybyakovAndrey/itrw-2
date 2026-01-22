<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/CreateComment.php';
require_once __DIR__ . '/DeletePost.php';

$pdo = new PDO('sqlite:' . __DIR__ . '/../db.sqlite');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Добавление поста в БД через запрос
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $path === '/posts/comment') {
    header('Content-Type: application/json');

    $input = json_decode(file_get_contents('php://input'), true);

    $useCase = new CreateComment(
        new \App\Repositories\CommentRepository\CommentRepositoryImpl($pdo),
        new \App\Repositories\UserRepository\UserRepositoryImpl($pdo),
        new \App\Repositories\PostRepository\PostRepositoryImpl($pdo)
    );

    try {
        $useCase->handle($input);
        http_response_code(201);
        echo json_encode(['status' => 'ok']);
    } catch (\InvalidArgumentException $e) {
        http_response_code(400);
        echo json_encode(['error' => $e->getMessage()]);
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }

    exit;
}

// Условие на удаление поста, после удаления удаляется комментарий из БД
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && $path === '/posts') {
    header('Content-Type: application/json');

    parse_str($_SERVER['QUERY_STRING'], $query);
    $uuid = $query['uuid'] ?? '';

    $useCase = new DeletePost(
        new \App\Repositories\PostRepository\PostRepositoryImpl($pdo)
    );

    try {
        $useCase->handle($uuid);
        echo json_encode(['status' => 'deleted']);
    } catch (\InvalidArgumentException $e) {
        http_response_code(400);
        echo json_encode(['error' => $e->getMessage()]);
    }

    exit;
}


http_response_code(404);
header('Content-Type: application/json');
echo json_encode(['error' => 'Route not found']);