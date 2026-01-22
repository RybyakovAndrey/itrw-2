<?php

$conn = new PDO('sqlite:' . __DIR__ . "/db.sqlite");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$conn->exec('PRAGMA foreign_keys = ON');

try {
    $conn->exec("
        INSERT INTO users (uuid, user_name, first_name, last_name)
        VALUES (
            '11111111-1111-1111-1111-111111111111',
            'testuser',
            'Test',
            'User'
        )
    ");

    $conn->exec("
        INSERT INTO posts (uuid, author_uuid, title, text)
        VALUES (
            '22222222-2222-2222-2222-222222222222',
            '11111111-1111-1111-1111-111111111111',
            'Test Post',
            'Текст тестового поста'
        )
    ");

    $conn->exec("
        INSERT INTO comments (uuid, post_uuid, author_uuid, text)
        VALUES (
            '33333333-3333-3333-3333-333333333333',
            '22222222-2222-2222-2222-222222222222',
            '11111111-1111-1111-1111-111111111111',
            'Первый тестовый комментарий'
        )
    ");

    echo "Тестовые данные добавлены успешно";

} catch (PDOException $e) {
    echo "Ошибка при добавлении тестовых данных: " . $e->getMessage();
}

// JSON для добавления комментария:
//{
//  "author_uuid": "11111111-1111-1111-1111-111111111111",
//  "post_uuid": "22222222-2222-2222-2222-222222222222",
//  "text": "Второй тестовый комментарий"
//}