<?php

use Phalcon\Mvc\Model;

class Product extends Model
{
    public $id;

    public $name;
    
    public $weight;
    
    public $type_id;
    
    // Название таблицы
    public function getSource()
    {
        return "product";
    }
    
    public function initialize()
    {
        // Product.type_id (много) <-> (один) ProductType.id
        $this->belongsTo("type_id", "ProductType", "id");
        
        // Product.id (один) <-> (много) Shipment.product_id
        $this->hasMany("id", "Shipment", "product_id");
    }

}
