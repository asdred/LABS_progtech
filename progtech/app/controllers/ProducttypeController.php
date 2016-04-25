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
    
    public function editAction($id)
    {

        if (!$this->request->isPost()) {

            $producttype = ProductType::findFirstById($id);
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

        $id = $this->request->getPost("id", "int");
        $producttype = ProductType::findFirstById($id);
        
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
        $this->view->form = new ProducttypeForm(null, array('edit' => true));
    }
    
    public function createAction()
    {
        if (!$this->request->isPost()) {
            return $this->forward("producttype/index");
        }

        $form = new ProducttypeForm;
        $company = new ProductType();

        $data = $this->request->getPost();
        if (!$form->isValid($data, $company)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('producttype/new');
        }

        if ($company->save() == false) {
            foreach ($company->getMessages() as $message) {
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
        $producttype = ProductType::findFirstById($id);
        
        if (!$producttype) {
            $this->flash->error("Тип товара не найден");
            return $this->forward("producttype/index");
        }
        
        $producttype->delete++;

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
