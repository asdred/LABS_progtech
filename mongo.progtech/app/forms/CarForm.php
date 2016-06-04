<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Select;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;

class CarForm extends Form
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

        // select - Диллер
        $dealer = new MySelect('dealer_id', Dealer::find(array(array("del" => 0))), $entity->dealer_id);
        $dealer->setLabel('Диллер');
        $this->add($dealer);
        
        // select - Водитель
        $driver = new MySelect('driver_id', Driver::find(array(array("del" => 0))), $entity->driver_id);
        $driver->setLabel('Водитель');
        $this->add($driver);
        
        // select - Владелец
        $owner = new MySelect('owner_id', Owner::find(array(array("del" => 0))), $entity->owner_id);
        $owner->setLabel('Владелец');
        $this->add($owner);
        
        // text - Модель
        $model = new Text("model");
        $model->setLabel("Модель");
        $model->setFilters(array('striptags', 'string'));
        $model->addValidators(array(
            new PresenceOf(array(
                'message' => 'model is required'
            ))
        ));
        $this->add($model);
        
        // text - capacity
        $capacity = new Text("capacity");
        $capacity->setLabel("Грузоподъмность");
        $capacity->setFilters(array('striptags', 'trim', 'int'));
        $capacity->addValidators(array(
            new PresenceOf(array(
                'message' => 'capacity is required'
            ))
        ));
        $this->add($capacity);
    }

}