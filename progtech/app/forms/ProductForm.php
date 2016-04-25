<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Select;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;

class ProductForm extends Form
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

        $name = new Text("name");
        $name->setLabel("Название");
        $name->setFilters(array('striptags', 'string'));
        $name->addValidators(array(
            new PresenceOf(array(
                'message' => 'Name is required'
            ))
        ));
        $this->add($name);
        
        $weight = new Text("weight");
        $weight->setLabel("Масса 1 куба в кг");
        $weight->setFilters(array('striptags', 'string'));
        $weight->addValidators(array(
            new PresenceOf(array(
                'message' => 'weight is required'
            ))
        ));
        $this->add($weight);
        
        $producttype = new Select('type_id', ProductType::find(), array(
            'using'      => array('id', 'name'),
            'useEmpty'   => true,
            'emptyText'  => '...',
            'emptyValue' => ''
        ));
        $producttype->setLabel('Тип продукта');
        $this->add($producttype);
        
        
    }

}