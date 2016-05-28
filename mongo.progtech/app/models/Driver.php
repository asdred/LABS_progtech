<?php

use Phalcon\Mvc\Collection;

class Driver extends Collection
{
    public $_id;
    
    public $id;

    public $name;
    
    public $experience;
    
    public $salary;
     
    public $del;
    
    // Название таблицы
    public function getSource()
    {
        return "driver";
    }
}
