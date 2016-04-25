<?php

use Phalcon\Mvc\Model;

class Driver extends Model
{
    public $id;

    public $name;
    
    public $experience;
    
    public $salary;
     
    public $delete;
    
    // Название таблицы
    public function getSource()
    {
        return "driver";
    }
    
    public function initialize()
    {
        // Driver.id (один) <-> (много) Car.driver_id
        $this->hasMany("id", "Car", "driver_id");
    }

}
