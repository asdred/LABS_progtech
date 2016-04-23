<?php

use Phalcon\Flash;
use Phalcon\Session;
use Phalcon\Paginator\Adapter\Model as Paginator;

class OwnerController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Владельцы');
        parent::initialize();
    }

    public function indexAction($numberPage = 1)
    {
        $owners = Owner::find();
        
        $paginator = new Paginator(array(
            "data"  => $owners,
            "limit" => 10,
            "page"  => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }
    
    public function editAction($id)
    {

        if (!$this->request->isPost()) {

            $owner = Owner::findFirstById($id);
            if (!$owner) {
                $this->flash->error("Владелец не найден");
                return $this->forward("owner/index");
            }

            $this->view->form = new OwnerForm($owner, array('edit' => true));
        }
    }
}
