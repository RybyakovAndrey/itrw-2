<?php

class WeightProduct extends ProductDecorator
{
    private float $weight = 0;
    public function __construct(Product $product, float $weight) {
        $this->weight = $weight;
        parent::__construct($product);
    }

    public function calculatePrice(): float {
        return $this->product->calculatePrice() * $this->weight;
    }
}