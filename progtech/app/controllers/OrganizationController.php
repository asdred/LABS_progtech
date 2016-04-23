<?php

use Phalcon\Flash;
use Phalcon\Session;
use Phalcon\Paginator\Adapter\Model as Paginator;

class OrganizationController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Организации');
        parent::initialize();
    }

    public function indexAction($numberPage = 1)
    {
        $organizations = Organization::find();
        
        $paginator = new Paginator(array(
            "data"  => $organizations,
            "limit" => 10,
            "page"  => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }
}
