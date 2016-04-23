<?php

use Phalcon\Flash;
use Phalcon\Session;
use Phalcon\Paginator\Adapter\Model as Paginator;

class DriverController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Водители');
        parent::initialize();
    }

    public function indexAction($numberPage = 1)
    {   
        $drivers = Driver::find();
        
        $paginator = new Paginator(array(
            "data"  => $drivers,
            "limit" => 10,
            "page"  => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }
}
