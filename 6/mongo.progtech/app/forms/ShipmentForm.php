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
        } elseif (!isset($options['create'])) {
            $this->add(new Hidden("id"));
        }

        $product = new MySelect('product_id', Product::find(array(array("del" => 0))), $entity->product_id);
        $product->setLabel('Продукт');
        $this->add($product);
        
        $transportation = new MySelect('transportation_id', Transportation::find(array(array("del" => 0))), $entity->transportation_id);
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