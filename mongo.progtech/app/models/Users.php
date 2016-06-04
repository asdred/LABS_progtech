<?php

use Phalcon\Mvc\Collection;
use Phalcon\Mvc\Model\Validator\Email as EmailValidator;
use Phalcon\Mvc\Model\Validator\Uniqueness as UniquenessValidator;

class Users extends Collection
{
    // Название таблицы
    public function getSource()
    {
        return "user";
    }
    
    // Валидация
    public function validation()
    {
        // Валидация email
        $this->validate(new EmailValidator(array(
            'field' => 'email'
        )));
        
        // Валидация email - уникальность
        $this->validate(new UniquenessValidator(array(
            'field' => 'email',
            'message' => 'Sorry, The email was registered by another user'
        )));
        
        // Валидация username - уникальность
        $this->validate(new UniquenessValidator(array(
            'field' => 'username',
            'message' => 'Sorry, That username is already taken'
        )));
        
        // Валидация провалилась
        if ($this->validationHasFailed() == true) {
            return false;
        }
    }
}