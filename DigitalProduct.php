<?php

class DigitalProduct extends ProductDecorator {

    public function calculatePrice(): float
    {
        return $this->product->calculatePrice() / 2;
    }
}