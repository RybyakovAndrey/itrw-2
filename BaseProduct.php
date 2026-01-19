<?php

// Тут определил конкретный класс наследника Product, который реализует метод CalculatePrice
// по умолчанию мы просто возвращаем цену товара из абстрактного класса Product
class BaseProduct extends Product
{
    public function calculatePrice() : float {
        return $this->price;
    }
}