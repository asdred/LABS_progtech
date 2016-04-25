<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;

class OrganizationForm extends Form
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
        
        $address = new Text("address");
        $address->setLabel("Адрес");
        $address->setFilters(array('striptags', 'string'));
        $address->addValidators(array(
            new PresenceOf(array(
                'message' => 'address is required'
            ))
        ));
        $this->add($address);
    }

}