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
        } else {
            $this->add(new Hidden("id"));
        }
        
        $car = new Select('car_id', Car::find("del = 0"), array(
            'using'      => array('id', 'model'),
            'useEmpty'   => true,
            'emptyText'  => '...',
            'emptyValue' => ''
        ));
        $car->setLabel('Автомобиль');
        $this->add($car);
        
        $organization = new Select('organization_id', Organization::find("del = 0"), array(
            'using'      => array('id', 'name'),
            'useEmpty'   => true,
            'emptyText'  => '...',
            'emptyValue' => ''
        ));
        $organization->setLabel('Организация');
        $this->add($organization);
        
        $store = new Select('store_id', Store::find("del = 0"), array(
            'using'      => array('id', 'name'),
            'useEmpty'   => true,
            'emptyText'  => '...',
            'emptyValue' => ''
        ));
        $store->setLabel('Склад');
        $this->add($store);

        $date = new Date('date');
        $date->setLabel("Дата");
        $this->add($date);
    }
}