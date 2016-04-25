<?php

use Phalcon\Mvc\Model;

class Transportation extends Model
{
    public $id;

    public $car_id;

    public $organization_id;

    public $store_id;

    public $date;
     
    public $delete;
    
    // Название таблицы
    public function getSource()
    {
        return "transportation";
    }
    
    public function initialize()
    {
        // Transportation.car_id (много) <-> (один) Car.id
        $this->belongsTo("car_id", "Car", "id");
        
        // Transportation.organization_id (много) <-> (один) Organization.id
        $this->belongsTo("organization_id", "Organization", "id");
        
        // Transportation.store_id (много) <-> (один) Store.id
        $this->belongsTo("store_id", "Store", "id");
        
        // Transportation.id (один) <-> (много) Shipment.Transportation_id
        $this->hasMany("id", "Shipment", "Transportation_id");
    }

}
