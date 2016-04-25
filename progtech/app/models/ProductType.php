<?php

use Phalcon\Mvc\Model;

class ProductType extends Model
{
    public $id;

    public $name;
     
    public $delete;
    
    // Название таблицы
    public function getSource()
    {
        return "product_type";
    }
    
    public function initialize()
    {
        // ProductType.id (один) <-> (много) Product.type_id
        $this->hasMany("id", "Product", "type_id");
    }

}