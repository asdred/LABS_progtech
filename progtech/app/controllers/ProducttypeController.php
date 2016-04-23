<?php

use Phalcon\Flash;
use Phalcon\Session;
use Phalcon\Paginator\Adapter\Model as Paginator;

class ProducttypeController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Типы товаров');
        parent::initialize();
    }

    public function indexAction($numberPage = 1)
    {
        $productTypes = ProductType::find();
        
        $paginator = new Paginator(array(
            "data"  => $productTypes,
            "limit" => 10,
            "page"  => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }
}
