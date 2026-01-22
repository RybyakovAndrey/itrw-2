<?php

$conn = new PDO('sqlite:' . __DIR__ . "/db.sqlite");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$conn->exec('PRAGMA foreign_keys = ON');

$conn->exec("DROP TABLE IF EXISTS comments");
$conn->exec("DROP TABLE IF EXISTS posts");
$conn->exec("DROP TABLE IF EXISTS users");
$conn->exec("DROP TABLE IF EXISTS post_likes");

try {
    $conn->exec("
        CREATE TABLE IF NOT EXISTS users (
            uuid TEXT PRIMARY KEY,
            user_name TEXT NOT NULL,
            first_name TEXT NOT NULL,
            last_name TEXT NOT NULL
        )
    ");

    $conn->exec("
        CREATE TABLE IF NOT EXISTS posts (
            uuid TEXT PRIMARY KEY,
            author_uuid TEXT NOT NULL,
            title TEXT NOT NULL,
            text TEXT NOT NULL,
            FOREIGN KEY (author_uuid) REFERENCES users(uuid)
        )
    ");

    $conn->exec("
        CREATE TABLE IF NOT EXISTS comments (
            uuid TEXT PRIMARY KEY,
            post_uuid TEXT NOT NULL,
            author_uuid TEXT NOT NULL,
            text TEXT NOT NULL,
            FOREIGN KEY (post_uuid) REFERENCES posts(uuid) ON DELETE CASCADE,
            FOREIGN KEY (author_uuid) REFERENCES users(uuid)
        )
    ");
    $conn->exec("
        CREATE TABLE IF NOT EXISTS post_likes (
            uuid TEXT PRIMARY KEY,
            post_uuid TEXT NOT NULL,
            user_uuid TEXT NOT NULL,
            FOREIGN KEY (post_uuid) REFERENCES posts(uuid) ON DELETE CASCADE,
            FOREIGN KEY (user_uuid) REFERENCES users(uuid),
            UNIQUE(post_uuid, user_uuid)
        )
    ");

    echo "Таблицы успешно созданы!";
} catch (PDOException $e) {
    echo "Ошибка при создании таблиц: " . $e->getMessage();
}