<?php

use Phalcon\Flash;
use Phalcon\Session;
use Phalcon\Paginator\Adapter\Model as Paginator;

class ShipmentController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Грузы');
        parent::initialize();
    }

    public function indexAction($numberPage = 1)
    {
        $shipments = Shipment::find();
        
        $paginator = new Paginator(array(
            "data"  => $shipments,
            "limit" => 10,
            "page"  => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }
}
