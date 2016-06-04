<?php

use Phalcon\Mvc\Collection;

class Car extends Collection
{
    public $_id;
    
    public $id;

    public $dealer_id;

    public $driver_id;

    public $owner_id;
    
    public $model;

    public $capacity;
    
    public $del;
    
    // Название таблицы
    public function getSource()
    {
        return "car";
    }
}
