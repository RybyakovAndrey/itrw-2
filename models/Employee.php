<?php
// Пример наследника User, помимо пользователя может закрывать заказ
class Employee extends User {
    private string $address;
    private string $INN;
    private string $CardNumber;
    public function __construct(string $firstName, $lastName, $phoneNumber, $address, $INN, $cardNumber) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->phoneNumber = $phoneNumber;
        $this->address = $address;
        $this->INN = $INN;
        $this->CardNumber = $cardNumber;
    }

    public function closeOrder(Order $order) {
        $order->closeOrder();
    }

}