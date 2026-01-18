<?php
// Обязанности класса:
// knowing: знает айди, имя и цену товара
// doing: можно добавить комментарий к товару (review)
// К пункту 4: Можно создавать разные типы продуктов (из задания №2 может быть весовой продукт,
//              количественный или цифровой). Следовательно можно переопределить методы расчёта
//              цены, а также добавить для этого новые поля
class Product
{
    private int $productId;
    private string $name;
    private float $price;
    private $reviews;
    public function __construct($productId, $name, $price) {
        $this->productId = $productId;
        $this->name = $name;
        $this->price = $price;
    }

    public function getName() {
        return $this->name;
    }
    public function getPrice() {
        return $this->price;
    }
    public function getReviews() {
        return $this->reviews;
    }
    // Можно реализовать одобренные админом review
    public function getGoodReviews() {
        // Реализовать по статусу true у объекта review в массиве reviews
    }
    public function addReview($user, $review) {
        $review = new Review($user, $review);
        array_push($this->reviews, $review);
    }
}