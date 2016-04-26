<?php

use Phalcon\Flash;
use Phalcon\Session;
use Phalcon\Paginator\Adapter\Model as Paginator;

class DriverController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Водители');
        parent::initialize();
    }

    public function indexAction($numberPage = 1)
    {   
        $drivers = Driver::find();
        
        $paginator = new Paginator(array(
            "data"  => $drivers,
            "limit" => 10,
            "page"  => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }
    
    public function editAction($id)
    {

        if (!$this->request->isPost()) {

            $driver = Driver::findFirstById($id);
            if (!$driver) {
                $this->flash->error("Водитель не найден");
                return $this->forward("driver/index");
            }

            $this->view->form = new DriverForm($driver, array('edit' => true));
        }
    }
    
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            return $this->forward("driver/index");
        }

        $id = $this->request->getPost("id", "int");
        $driver = Driver::findFirstById($id);
        
        if (!$driver) {
            $this->flash->error("Водитель не найден");
            return $this->forward("driver/index");
        }

        $form = new DriverForm;

        $data = $this->request->getPost();
        if (!$form->isValid($data, $driver)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('driver/new');
        }
        

        if ($driver->save() == false) {
            foreach ($driver->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('driver/new');
        }

        $form->clear();

        $this->flash->success("Водитель успешно изменён");
        return $this->forward("driver/index");
    }
    
    public function newAction()
    {
        $this->view->form = new DriverForm(null, array('edit' => true));
    }
    
    public function createAction()
    {
        if (!$this->request->isPost()) {
            return $this->forward("driver/index");
        }

        $form = new DriverForm;
        $company = new Driver();

        $data = $this->request->getPost();
        if (!$form->isValid($data, $company)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('driver/new');
        }

        if ($company->save() == false) {
            foreach ($company->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('driver/new');
        }

        $form->clear();

        $this->flash->success("Водитель успешно создан");
        return $this->forward("driver/index");
    }
    
    public function deleteAction($id)
    {
        $driver = Driver::findFirstById($id);
        
        if (!$driver) {
            $this->flash->error("Водитель не найден");
            return $this->forward("driver/index");
        }
        
        $driver->del = 1;

        if ($driver->save() == false) {
            foreach ($driver->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('driver/new');
        }

        $this->flash->success("Водитель успешно удалён");
        return $this->forward("driver/index");
    }
}
