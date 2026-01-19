<?php

require_once 'Product.php';
require_once 'ProductDecorator.php';
require_once 'BaseProduct.php';
require_once 'DigitalProduct.php';
require_once 'QuantityProduct.php';
require_once 'WeightProduct.php';

// Реализовывал всё с помощью паттергна "Декоратор"

// Пример сценария:
// BaseProduct - класс, наследник класса Product,
// который осздаёт книгу, далее через этот класс создаются версии этой книги:
// цифровая (digital) или физическая/штучная (physical/quantity)
$baseBook = new BaseProduct("Чистый код", 1000);

// Если мы делаем книгу цифровой, цена будет 500 руб - в 2 раза меньше, чем у базового товара
$digitalBook = new DigitalProduct($baseBook);
echo 'Цена цифрового. экзмепляра книги "Чистый код": ' . $digitalBook->calculatePrice() . " руб.\n";

// Если мы делаем её штучной или физической, то цена будет, как у базового товара
$physicalBook = new QuantityProduct($baseBook);
echo 'Цена физического экзмепляра книги "Чистый код": ' . $physicalBook->calculatePrice() ." руб.\n";

// Также с помощью декоратора мы можем "переконвертировать физическую книгу в цифровую"

echo "\n";

$convertedToDigitalBook = new DigitalProduct($physicalBook);
echo 'Цена цифрового экземпляра (конвертировали из Quantity в Digital), книги "Чистый код": ';
echo $convertedToDigitalBook->calculatePrice() . "\n";



// Цена весового товара считается аналогичным образом

echo "\n";

$baseApples = new BaseProduct("Яблоки", 150);
$apples = new WeightProduct($baseApples, 2.5);
echo "Цена 2.5 кг яблок: " . $apples->calculatePrice() . " руб.\n";