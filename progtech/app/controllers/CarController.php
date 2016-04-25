<?php

use Phalcon\Flash;
use Phalcon\Session;
use Phalcon\Paginator\Adapter\Model as Paginator;

class CarController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Автомобили');
        parent::initialize();
    }

    public function indexAction($numberPage = 1)
    {
        $cars = Car::find();
        
        $paginator = new Paginator(array(
            "data"  => $cars,
            "limit" => 10,
            "page"  => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }
    
    public function editAction($id)
    {

        if (!$this->request->isPost()) {

            $car = Car::findFirstById($id);
            if (!$car) {
                $this->flash->error("Автомобиль не найден");
                return $this->forward("car/index");
            }

            $this->view->form = new CarForm($car, array('edit' => true));
        }
    }
    
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            return $this->forward("car/index");
        }

        $id = $this->request->getPost("id", "int");
        $car = Car::findFirstById($id);
        
        if (!$car) {
            $this->flash->error("Автомобиль не найден");
            return $this->forward("car/index");
        }

        $form = new CarForm;

        $data = $this->request->getPost();
        if (!$form->isValid($data, $car)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('car/new');
        }
        

        if ($car->save() == false) {
            foreach ($car->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('car/new');
        }

        $form->clear();

        $this->flash->success("Автомобиль успешно изменён");
        return $this->forward("car/index");
    }
    
    public function newAction()
    {
        $this->view->form = new CarForm(null, array('edit' => true));
    }
    
    public function createAction()
    {
        if (!$this->request->isPost()) {
            return $this->forward("car/index");
        }

        $form = new CarForm;
        $company = new Car();

        $data = $this->request->getPost();
        if (!$form->isValid($data, $company)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('car/new');
        }

        if ($company->save() == false) {
            foreach ($company->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('car/new');
        }

        $form->clear();

        $this->flash->success("Автомобиль успешно создан");
        return $this->forward("car/index");
    }
    
    public function deleteAction($id)
    {
        $car = Car::findFirstById($id);
        
        if (!$car) {
            $this->flash->error("Автомобиль не найден");
            return $this->forward("car/index");
        }
        
        $car->delete++;

        if ($car->save() == false) {
            foreach ($car->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('car/new');
        }

        $this->flash->success("Автомобиль успешно удалён");
        return $this->forward("car/index");
    }
}
