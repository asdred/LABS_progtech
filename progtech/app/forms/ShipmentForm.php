<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Select;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;

class ShipmentForm extends Form
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

        $product = new Select('product_id', Product::find(), array(
            'using'      => array('id', 'name'),
            'useEmpty'   => true,
            'emptyText'  => '...',
            'emptyValue' => ''
        ));
        $product->setLabel('Продукт');
        $this->add($product);
        
        $transportation = new Select('transportation_id', Transportation::find(), array(
            'using'      => array('id', 'id'),
            'useEmpty'   => true,
            'emptyText'  => '...',
            'emptyValue' => ''
        ));
        $transportation->setLabel('Номер перевозки');
        $this->add($transportation);
        
        $amount = new Text("amount");
        $amount->setLabel("Количество");
        $amount->setFilters(array('striptags', 'trim', 'int'));
        $amount->addValidators(array(
            new PresenceOf(array(
                'message' => 'amount is required'
            ))
        ));
        $this->add($amount);
    }
}