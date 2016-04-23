<?php

use Phalcon\Flash;
use Phalcon\Session;
use Phalcon\Paginator\Adapter\Model as Paginator;

class DealerController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Диллеры');
        parent::initialize();
    }

    public function indexAction($numberPage = 1)
    {
        $dealers = Dealer::find();
        
        $paginator = new Paginator(array(
            "data"  => $dealers,
            "limit" => 10,
            "page"  => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }
}
