<?php

use Phalcon\Flash;
use Phalcon\Session;
use Phalcon\Paginator\Adapter\Model as Paginator;

class StoreController extends ControllerBase
{
    private $cascade = false;
    
    public function initialize()
    {
        $this->tag->setTitle('Склады');
        parent::initialize();
    }

    public function indexAction($numberPage = 1)
    {
        $stores = Store::find();
        
        // Каскадное обновление
        if ($cascade) {
            foreach($stores as $store) {
            if ($store->owner->del == 1) {
                $store->del = 1;
                $store->save();
                }
            }
            $cascade = false;
        }
        
        $paginator = new Paginator(array(
            "data"  => $stores,
            "limit" => 10,
            "page"  => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }
    
    public function editAction($id)
    {

        if (!$this->request->isPost()) {

            $store = Store::findFirstById($id);
            if (!$store) {
                $this->flash->error("Склад не найден");
                return $this->forward("store/index");
            }

            $this->view->form = new StoreForm($store, array('edit' => true));
        }
    }
    
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            return $this->forward("store/index");
        }

        $id = $this->request->getPost("id", "int");
        $store = Store::findFirstById($id);
        
        if (!$store) {
            $this->flash->error("Склад не найден");
            return $this->forward("store/index");
        }

        $form = new StoreForm;

        $data = $this->request->getPost();
        if (!$form->isValid($data, $store)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('store/new');
        }
        

        if ($store->save() == false) {
            foreach ($store->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('store/new');
        }

        $form->clear();

        $this->flash->success("Склад успешно изменён");
        return $this->forward("store/index");
    }
    
    public function newAction()
    {
        $this->view->form = new StoreForm(null, array('edit' => true));
    }
    
    public function createAction()
    {
        if (!$this->request->isPost()) {
            return $this->forward("store/index");
        }

        $form = new StoreForm;
        $company = new Store();

        $data = $this->request->getPost();
        if (!$form->isValid($data, $company)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('store/new');
        }

        if ($company->save() == false) {
            foreach ($company->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('store/new');
        }

        $form->clear();

        $this->flash->success("Склад успешно создан");
        return $this->forward("store/index");
    }
    
    public function deleteAction($id)
    {
        $store = Store::findFirstById($id);
        
        if (!$store) {
            $this->flash->error("Склад не найден");
            return $this->forward("store/index");
        }
        
        $store->del = 1;

        if ($store->save() == false) {
            foreach ($store->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('store/new');
        }

        $cascade = true;
        $this->flash->success("Склад успешно удалён");
        return $this->forward("store/index");
    }
}
