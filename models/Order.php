<?php

// Обязанности класса:
// knowing: знает о продуктах и их количестве, времени заказа и т.д. (все поля и методы в get)
// doing: 1. Создаёт чек на основе заказа

require_once 'Product.php';
require_once 'OrderProduct.php';
require_once 'User.php';
require_once 'Cart.php';
require_once 'Order.php';

class Order
{
    private int $orderId;
    private array $orderProducts;
    private float $totalPrice = 0;
    private $orderTime;
    private User $customer;
    private string $address;
    private bool $paid = false;
    public function __construct($orderId, $orderProducts, $customer, $address)
    {
        $this->orderId = $orderId;
        $this->orderProducts = $orderProducts;
        $this->customer = $customer;
        $this->address = $address;
        $this->orderTime = time();
    }

    public function closeOrder() : void {
        $this->paid = true;
    }

    public function getOrderReport() {

        if (!$this->paid) {
            return "Заказ не оплачен, чек нельзя распечатать";
        }

        $customerFullName = $this->customer->getFullName();
        $date = date('d.m.Y', $this->orderTime);
        $totalPrice = 0;

        $productsText = "Товар\tКол-во\tЦена\tИтого\n";
        $productsText .= "\t-----------------------------\n";

        for ($i = 0; $i < count($this->orderProducts); $i++) {
            $product = $this->orderProducts[$i];

            $name = $product->getName();
            $quantity = $product->getQuantity();
            $price = $product->getPrice();
            $sum = $quantity * $price;

            $this->totalPrice += $sum;

            $productsText .= "\t{$name}\t{$quantity}\t{$price}\t{$sum}\n}";
        }

        return "\tЧек № {$this->orderId} от $date\n
        Покупатель: $customerFullName\n
        Адрес: $this->address\n
        Товары: \t$productsText\n
        \n
        Итого: $totalPrice\n";
    }

    public function getOrderProducts() {
        return $this->orderProducts;
    }
    public function getCustomer() {
        return $this->customer;
    }
    public function getTotalPrice() {
        return $this->totalPrice;
    }
    public function getOrderTime() {
        return $this->time;
    }
    public function getAddress() {
        return $this->address;
    }
}