<?php

use Phalcon\Mvc\Collection;

class Store extends Collection
{
    public $_id;
    
    public $id;

    public $name;
    
    public $owner_id;
     
    public $del;
    
    // Название таблицы
    public function getSource()
    {
        return "store";
    }
}
