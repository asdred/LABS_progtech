<?php

use Phalcon\Mvc\Collection;

class Shipment extends Collection
{
    public $_id;
    
    public $id;

    public $product_id;
    
    public $transportation_id;
    
    public $amount;
     
    public $del;
    
    // Название таблицы
    public function getSource()
    {
        return "shipment";
    }
}
