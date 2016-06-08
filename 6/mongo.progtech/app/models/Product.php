<?php

use Phalcon\Mvc\Collection;

class Product extends Collection
{
    public $_id;
    
    public $id;

    public $name;
    
    public $weight;
    
    public $type_id;
     
    public $del;
    
    // Название таблицы
    public function getSource()
    {
        return "product";
    }
}
