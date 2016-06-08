<?php

use Phalcon\Flash;
use Phalcon\Session;
use Phalcon\Paginator\Adapter\NativeArray as Paginator;

class ProducttypeController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Типы товаров');
        parent::initialize();
    }

    public function indexAction($numberPage = 1)
    {
        $productTypes = ProductType::find(array(array("del" => 0)));
        
        $paginator = new Paginator(array(
            "data"  => $productTypes,
            "limit" => 10,
            "page"  => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }
    
    public function editAction($id)
    {

        if (!$this->request->isPost()) {

            $producttype = ProductType::findFirst(array(array("id" => (int)$id)));
            if (!$producttype) {
                $this->flash->error("Тип продукта не найден");
                return $this->forward("producttype/index");
            }

            $this->view->form = new ProducttypeForm($producttype, array('edit' => true));
        }
    }
    
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            return $this->forward("producttype/index");
        }

        $id = $this->request->getPost("id");
        $producttype = ProductType::findById($id);
        
        if (!$producttype) {
            $this->flash->error("Тип товара не найден");
            return $this->forward("producttype/index");
        }

        $form = new ProducttypeForm;

        $data = $this->request->getPost();
        if (!$form->isValid($data, $producttype)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('producttype/new');
        }

        if ($producttype->save() == false) {
            foreach ($producttype->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('producttype/new');
        }

        $form->clear();

        $this->flash->success("Тип товара успешно изменён");
        return $this->forward("producttype/index");
    }
    
    public function newAction()
    {
        $this->view->form = new ProducttypeForm(null, array('edit' => true, 'create' => true));
    }
    
    public function createAction()
    {
        if (!$this->request->isPost()) {
            return $this->forward("producttype/index");
        }

        $form = new ProducttypeForm;
        $producttype = new ProductType();

        $data = $this->request->getPost();
        if (!$form->isValid($data, $producttype)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('producttype/new');
        }
        
        $count = count(ProductType::find());
        $producttype->id = $count + 1;
        $producttype->del = 0;

        if ($producttype->save() == false) {
            foreach ($producttype->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('producttype/new');
        }

        $form->clear();

        $this->flash->success("Тип товара успешно создан");
        return $this->forward("producttype/index");
    }
    
    public function deleteAction($id)
    {
        $producttype = ProductType::findFirst(array(array("id" => (int)$id)));
        
        if (!$producttype) {
            $this->flash->error("Тип товара не найден");
            return $this->forward("producttype/index");
        }
        
        $producttype->del = 1;

        if ($producttype->save() == false) {
            foreach ($producttype->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('producttype/new');
        }

        $this->flash->success("Тип товара успешно удалён");
        return $this->forward("producttype/index");
    }
}
