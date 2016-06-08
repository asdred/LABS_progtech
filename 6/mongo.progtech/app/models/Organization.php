<?php

use Phalcon\Mvc\Collection;

class Organization extends Collection
{
    public $_id;
    
    public $id;

    public $name;
    
    public $address;
     
    public $del;
    
    // Название таблицы
    public function getSource()
    {
        return "organization";
    }
}
