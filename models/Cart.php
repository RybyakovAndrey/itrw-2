<?php

// Обязанности класса:
// knowing: знает о продуктах и их количестве (поле orderProducts, метод getProducts)
// doing: 1. может добавлять и удалять товары/ уменьшать и увеличвать их кол-во
//              методы: add, remove, increment, decrement Product

class Cart
{
    private array $orderProducts = [];

    public function getProducts() {
        return $this->orderProducts;
    }

    public function addProduct(Product $product, int $quantity=1) {
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
}

