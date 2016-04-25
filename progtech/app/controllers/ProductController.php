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
    
    public function editAction($id)
    {

        if (!$this->request->isPost()) {

            $product = Product::findFirstById($id);
            if (!$product) {
                $this->flash->error("Продукт не найден");
                return $this->forward("product/index");
            }

            $this->view->form = new ProductForm($product, array('edit' => true));
        }
    }
    
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            return $this->forward("product/index");
        }

        $id = $this->request->getPost("id", "int");
        $product = Product::findFirstById($id);
        
        if (!$product) {
            $this->flash->error("Товар не найден");
            return $this->forward("product/index");
        }

        $form = new ProductForm;

        $data = $this->request->getPost();
        if (!$form->isValid($data, $product)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('product/new');
        }
        

        if ($product->save() == false) {
            foreach ($product->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('product/new');
        }

        $form->clear();

        $this->flash->success("Товар успешно изменён");
        return $this->forward("product/index");
    }
    
    public function newAction()
    {
        $this->view->form = new ProductForm(null, array('edit' => true));
    }
    
    public function createAction()
    {
        if (!$this->request->isPost()) {
            return $this->forward("product/index");
        }

        $form = new ProductForm;
        $company = new Product();

        $data = $this->request->getPost();
        if (!$form->isValid($data, $company)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('product/new');
        }

        if ($company->save() == false) {
            foreach ($company->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('product/new');
        }

        $form->clear();

        $this->flash->success("Товар успешно создан");
        return $this->forward("product/index");
    }
    
    public function deleteAction($id)
    {
        $product = Product::findFirstById($id);
        
        if (!$product) {
            $this->flash->error("Товар не найден");
            return $this->forward("product/index");
        }
        
        $product->delete++;

        if ($product->save() == false) {
            foreach ($product->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('product/new');
        }

        $this->flash->success("Товар успешно удалён");
        return $this->forward("product/index");
    }
}
