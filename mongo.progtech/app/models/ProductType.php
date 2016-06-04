<?php

use Phalcon\Mvc\Collection;

class ProductType extends Collection
{
    public $_id;
    
    public $id;

    public $name;
     
    public $del;
    
    // Название таблицы
    public function getSource()
    {
        return "product_type";
    }
}