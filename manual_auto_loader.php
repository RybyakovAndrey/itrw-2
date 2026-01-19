<?php


spl_autoload_register(function ($class) {
    $baseDir = __DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR;
    $className = ltrim($class, '\\');

    $fileName = str_replace(['\\', '_'], DIRECTORY_SEPARATOR, $className);

    $fullPath = $baseDir . $fileName . '.php';

    if (file_exists($fullPath)) {
        require_once $fullPath;
    } else {
        echo "Файл не найден (автозагрузчик не смог найти файл в директории /src";
    }
});

// Тест из папки /src
$testLoader1 = new TestLoader1();

echo "\n";

// Тест из папки /src/testFolder
$testLoader2 = new \testFolder\TestLoader2();