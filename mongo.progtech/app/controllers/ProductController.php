<?php

use Phalcon\Flash;
use Phalcon\Session;
use Phalcon\Paginator\Adapter\NativeArray as Paginator;

class ProductController extends ControllerBase
{
    private $cascade = false;
    
    public function initialize()
    {
        $this->tag->setTitle('Товары');
        parent::initialize();
    }

    public function indexAction($numberPage = 1, $filter = null)
    {
        $filter = $this->request->getPost("filter");
        
        if (!$filter) {
            $products = Product::find(array(array("del" => 0)));
        } elseif ($filter == "max") {
            $products = Product::mostWeight();
            $this->view->status = "с наибольшим весом";
        } elseif ($filter == "min") {
            $products = Product::leastWeight();
            $this->view->status = "с наименьшим весом";
        }
        
        // Каскадное обновление
        if ($cascade) {
            foreach($products as $product) {
            if ($product->producttype->del == 1) {
                $product->del = 1;
                $product->save();
                }
            }
            $cascade = false;
        }
        
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

            $product = Product::findFirst(array(array("id" => (int)$id)));
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

        $id = $this->request->getPost("id");
        $product = Product::findById($id);
        
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
        $this->view->form = new ProductForm(null, array('edit' => true, 'create' => true));
    }
    
    public function createAction()
    {
        if (!$this->request->isPost()) {
            return $this->forward("product/index");
        }

        $form = new ProductForm;
        $product = new Product();

        $data = $this->request->getPost();
        if (!$form->isValid($data, $product)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('product/new');
        }
        
        $count = count(Product::find());
        $product->id = $count + 1;
        $product->del = 0;

        if ($product->save() == false) {
            foreach ($product->getMessages() as $message) {
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
        $product = Product::findFirst(array(array("id" => (int)$id)));
        
        if (!$product) {
            $this->flash->error("Товар не найден");
            return $this->forward("product/index");
        }
        
        $product->del = 1;

        if ($product->save() == false) {
            foreach ($product->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('product/new');
        }

        $cascade = true;
        $this->flash->success("Товар успешно удалён");
        return $this->forward("product/index");
    }
}
