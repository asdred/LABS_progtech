<?php

use Phalcon\Flash;
use Phalcon\Session;
use Phalcon\Paginator\Adapter\Model as Paginator;

class CarController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Автомобили');
        parent::initialize();
    }

    public function indexAction($numberPage = 1)
    {
        $cars = Car::find();
        
        $paginator = new Paginator(array(
            "data"  => $cars,
            "limit" => 10,
            "page"  => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }
}
