<?php

use Phalcon\Flash;
use Phalcon\Session;
use Phalcon\Paginator\Adapter\Model as Paginator;

class StoreController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Склады');
        parent::initialize();
    }

    public function indexAction($numberPage = 1)
    {
        $stores = Store::find();
        
        $paginator = new Paginator(array(
            "data"  => $stores,
            "limit" => 10,
            "page"  => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }
}
