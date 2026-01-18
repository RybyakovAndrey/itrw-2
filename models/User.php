<?php
// Обязанности класса:
// knowing: знает имя и фамилию пользователя
// doing: можно поменять пароль
// К пункту 4: Можно от пользователя наследовать админа и сотрудника.
//              К наследникам можно добавить новые поля: прописку, ИНН и другие необходимые
//              для работы поля. К сотруднику можно добавить метод "закрыть заказ", а администратору
//              добавить методы для манипуляции сотрудниками и добавления новых продуктов, одобрения комментариев

class User
{
    private string $firstName;
    private string $lastName;
    private int $phoneNumber;
    private string $login;
    private string $password;

    function __construct($firstName, $lastName, $phoneNumber, $login, $password) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->phoneNumber = $phoneNumber;
        $this->login = $login;
        $this->password = $password;
    }
    function getFullName() {
        return $this->firstName . ' ' . $this->lastName;
    }
    function getFirstName() {
        return $this->firstName;
    }
    function getLastName() {
        return $this->lastName;
    }
    function getPhoneNumber() {
        return $this->phoneNumber;
    }
    function changePassword($oldPassword, $newPassword) {
        if ($oldPassword === $this->password) {
            $this->password = $newPassword;
        }
    }

    function getLogin() {
        return $this->login;
    }
}

