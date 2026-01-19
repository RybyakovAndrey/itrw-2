<?php

require_once 'Product.php';
require_once 'OrderProduct.php';
require_once 'Order.php';
require_once 'User.php';
require_once 'Review.php';
require_once 'Employee.php';
require_once 'Feedback.php';

// Пример использоватния формы обратной связи:
$feedback = new Feedback("Андрей Рыбьяков", "Andrey@mail.com", "Нет доставился товар", "Что делать, если товар не пришёл, а дата доставки уже прошла");

echo $feedback->getFullInfo();

// Статус меняет Админ, например, после отправки инструкции пользователю
$feedback->setStatus(FeedbackStatus::Resolved);


// Пример создания продукта и добавления его в корзину и написания комментария:

$monitor = new Product(1, "Игровой монитор MSI", 15000.00);

$cart = new Cart();
$cart->addProduct($monitor);

$user = new User("Андрей", "Рыбьяков", "1923123", "andrey", "123");

$monitor->addReview($user,  "Супер крутой монитор, дешёвый");

print_r($cart->getProducts());

// Добавил логику создания заказа:
$order = new Order(1, $cart->getProducts(),$user,"Перекопская 15А");

$employee = new Employee("S", "s", "8 800 555 35 35", "a", "b", "c");

$employee->closeOrder($order);

echo $order->getOrderReport();