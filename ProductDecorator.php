<?php

// Наследники (digital, quantity, weight) класса ProductDecorator будут содержать экземпляр класса product
// Чотбы подсчитывать цену продукта, обращаясь к родителю

abstract class ProductDecorator extends Product {
    protected Product $product;

    public function __construct(Product $product) {
        parent::__construct($product->getName(), $product->getPrice());
        $this->product = $product;
    }
}