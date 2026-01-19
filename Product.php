<?php

abstract class Product
{
    protected string $name;
    protected float $price;
    public function __construct($name, $price) {
        $this->name = $name;
        $this->price = $price;
    }
    public function getName() {
        return $this->name;
    }
    public function getPrice() {
        return $this->price;
    }
    abstract public function calculatePrice() : float;
}