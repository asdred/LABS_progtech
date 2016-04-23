<?php

use Phalcon\Flash;
use Phalcon\Session;
use Phalcon\Paginator\Adapter\Model as Paginator;

class ProductController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Товары');
        parent::initialize();
    }

    public function indexAction($numberPage = 1)
    {
        $products = Product::find();
        
        $paginator = new Paginator(array(
            "data"  => $products,
            "limit" => 10,
            "page"  => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }
}
