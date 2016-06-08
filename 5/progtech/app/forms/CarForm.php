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
        } else {
            $this->add(new Hidden("id"));
        }

        // select - Диллер
        $dealer = new Select('dealer_id', Dealer::find("del = 0"), array(
            'using'      => array('id', 'name'),
            'useEmpty'   => true,
            'emptyText'  => '...',
            'emptyValue' => ''
        ));
        $dealer->setLabel('Диллер');
        $this->add($dealer);
        
        // select - Водитель
        $driver = new Select('driver_id', Driver::find("del = 0"), array(
            'using'      => array('id', 'name'),
            'useEmpty'   => true,
            'emptyText'  => '...',
            'emptyValue' => ''
        ));
        $driver->setLabel('Водитель');
        $this->add($driver);
        
        // select - Владелец
        $owner = new Select('owner_id', Owner::find("del = 0"), array(
            'using'      => array('id', 'name'),
            'useEmpty'   => true,
            'emptyText'  => '...',
            'emptyValue' => ''
        ));
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