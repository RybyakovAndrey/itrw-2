<?php
// Обязанности класса:
// knowing: имеет сведения о продукте и его количестве
class OrderProduct
{
    private Product $product;
    private int $quantity;

    public function __construct($product, $quantity) {
        $this->product = $product;
        $this->quantity = $quantity;
    }

    public function getName() {
        return $this->product->getName();
    }
    public function getPrice() {
        return $this->product->getPrice();
    }
    public function getQuantity() {
        return $this->quantity;
    }
}