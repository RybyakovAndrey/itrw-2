<?php

// Пример наследника User
// Может добавлять сотрудников и одобрять комментарии
// Также можно добавить: манипуляцию с товарами и дополнить манипуляцию с пользователями
class Admin extends User {
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
    public function ApplyFeedback(Feedback $feedback) {
        $feedback->applyFeedback(true);
        return true;
    }
    public function AddEmployee($firstName, $lastName, $phoneNumber, $address, $INN, $cardNumber) {
        return new Employee($this->firstName,
            $this->lastName,
            $this->phoneNumber,
            $this->address,
            $this->INN,
            $this->CardNumber);
    }
}