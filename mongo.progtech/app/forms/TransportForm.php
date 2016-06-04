<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Date;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;

class TransportForm extends Form
{

    /**
     * Initialize the companies form
     */
    public function initialize($entity = null, $options = array())
    {
        if (!isset($options['edit'])) {
            $element = new Text("id");
            $this->add($element->setLabel("Id"));
        } elseif (!isset($options['create'])) {
            $this->add(new Hidden("id"));
        }
        
        $car = new MySelect('car_id', Car::find(array(array("del" => 0))), $entity->car_id);
        $car->setLabel('Автомобиль');
        $this->add($car);
        
        $organization = new MySelect('organization_id', Organization::find(array(array("del" => 0))), $entity->organization_id);
        $organization->setLabel('Организация');
        $this->add($organization);
        
        $store = new MySelect('store_id', Store::find(array(array("del" => 0))), $entity->store_id);
        $store->setLabel('Склад');
        $this->add($store);
        
        $date = new Date('date');
        $date->setLabel("Дата");
        $this->add($date);
    }
}