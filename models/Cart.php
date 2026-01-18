<?php

// Обязанности класса:
// knowing: знает о продуктах и их количестве (поле orderProducts, метод getProducts)
// doing: 1. может добавлять и удалять товары/ уменьшать и увеличвать их кол-во
//              методы: add, remove, increment, decrement Product
//        2. создаёт на основе объектов в корзине заказ
//              метод: makeOrder

class Cart
{
    private array $orderProducts;

    public function getProducts() {
        return $this->orderProducts;
    }

    public function addProduct(Product $product, int $quantity) {
        array_push($this->orderProducts,
            new OrderProduct($product, $quantity));
    }

    public function removeProduct(Product $product) {
        unset($this->orderProducts, $product);
    }
    public function incrementProduct(Product $product) {

    }
    public function decrementProduct(Product $product) {

    }

    public function makeOrder($customer, $address) {
        $order = new Order($this->orderProducts,
            $customer,
            $address);
    }
}