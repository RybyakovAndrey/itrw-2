<?php

$conn = new PDO('sqlite:' . __DIR__ . "/db.sqlite");

$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "
        DROP TABLE IF EXISTS comments;
        DROP TABLE IF EXISTS posts;
        
        CREATE TABLE users (
        uuid TEXT PRIMARY KEY,
        user_name TEXT NOT NULL,
        first_name TEXT NOT NULL,
        last_name TEXT NOT NULL
    );
    
    CREATE TABLE posts (
        uuid TEXT PRIMARY KEY,
        author_uuid TEXT NOT NULL,
        title TEXT NOT NULL,
        text TEXT NOT NULL,
        FOREIGN KEY (author_uuid) REFERENCES users(uuid)
    );
    
    CREATE TABLE comments (
        uuid TEXT PRIMARY KEY,
        post_uuid TEXT NOT NULL,
        author_uuid TEXT NOT NULL,
        text TEXT NOT NULL,
        FOREIGN KEY (post_uuid) REFERENCES posts(uuid) ON DELETE CASCADE,
        FOREIGN KEY (author_uuid) REFERENCES users(uuid)
    );
";

try {
    $conn->exec($sql);
    echo "Таблицы успешно созданы в db.sqlite!";
} catch (PDOException $e) {
    echo "Ошибка при создании таблиц: " . $e->getMessage();
}