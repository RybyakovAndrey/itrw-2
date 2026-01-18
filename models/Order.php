<?php

// Обязанности класса:
// knowing: знает о продуктах и их количестве, времени заказа и т.д. (все поля и методы в get)
// doing: 1. Создаёт чек на основе заказа
class Order
{
    private int $orderId;
    private array $orderProducts;
    private float $totalPrice;
    private $orderTime;
    private User $customer;
    private string $address;
    private bool $paid;
    public function __construct($orderProducts, $customer, $address)
    {
        $this->orderProducts = $orderProducts;
        $this->customer = $customer;
        $this->address = $address;
        $this->orderTime = time();
    }


    public function getOrderReport() {

        if (!$this->paid) {
            return "Заказ не оплачен, чек нельзя распечатать";
        }

        $customerFullName = $this->customer->getFullName();
        $date = date('d.m.Y', $this->orderTime);
        $totalPrice = 0;

        $productsText = "Товар\tКол-во\tЦена\tИтого\n";
        $productsText .= "-----------------------------\n";

        for ($i = 0; $i < count($this->orderProducts); $i++) {
            $product = $this->orderProducts[$i];

            $name = $product->getName();
            $quantity = $product->getQuantity();
            $price = $product->getPrice();
            $sum = $quantity * $price;

            $this->totalPrice += $sum;

            $productsText .= "{$name}\t{$quantity}\t{$price}\t{$sum}\n}";
        }

        return "Чек № {$this->orderId} от $date\n
                Покупатель: $customerFullName\n
                Адрес: $this->address\n
                Товары: $productsText\n
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