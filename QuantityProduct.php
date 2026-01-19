<?php

class QuantityProduct extends ProductDecorator {
    private int $quantity = 1;
    public function __construct(Product $product, int $quantity = 1) {
        $this->$quantity = $quantity;
        parent::__construct($product);
    }
    public function calculatePrice(): float {
        return $this->product->calculatePrice() * $this->quantity;
    }
}