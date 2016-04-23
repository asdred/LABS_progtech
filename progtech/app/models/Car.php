<?php

use Phalcon\Mvc\Model;

class Car extends Model
{
    public $id;

    public $dealer_id;

    public $driver_id;

    public $owner_id;
    
    public $model;

    public $capacity;
    
    // Название таблицы
    public function getSource()
    {
        return "car";
    }
    
    public function initialize()
    {
        // Car.driver_id (много) <-> (один) Driver.id
        $this->belongsTo("driver_id", "Driver", "id");
        
        // Car.dealer_id (много) <-> (один) Dealer.id
        $this->belongsTo("dealer_id", "Dealer", "id");
        
        // Car.owner_id (много) <-> (один) Owner.id
        $this->belongsTo("owner_id", "Owner", "id");
    }

}
