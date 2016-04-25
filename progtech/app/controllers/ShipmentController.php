<?php

use Phalcon\Flash;
use Phalcon\Session;
use Phalcon\Paginator\Adapter\Model as Paginator;

class ShipmentController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Грузы');
        parent::initialize();
    }

    public function indexAction($numberPage = 1)
    {
        $shipments = Shipment::find();
        
        $paginator = new Paginator(array(
            "data"  => $shipments,
            "limit" => 10,
            "page"  => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }
    
    public function editAction($id)
    {

        if (!$this->request->isPost()) {

            $shipment = Shipment::findFirstById($id);
            if (!$shipment) {
                $this->flash->error("Груз не найден");
                return $this->forward("shipment/index");
            }

            $this->view->form = new ShipmentForm($shipment, array('edit' => true));
        }
    }
    
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            return $this->forward("shipment/index");
        }

        $id = $this->request->getPost("id", "int");
        $shipment = Shipment::findFirstById($id);
        
        if (!$shipment) {
            $this->flash->error("Груз не найден");
            return $this->forward("shipment/index");
        }

        $form = new ShipmentForm;

        $data = $this->request->getPost();
        if (!$form->isValid($data, $shipment)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('shipment/new');
        }
        

        if ($shipment->save() == false) {
            foreach ($shipment->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('shipment/new');
        }

        $form->clear();

        $this->flash->success("Груз успешно изменён");
        return $this->forward("shipment/index");
    }
    
    public function newAction()
    {
        $this->view->form = new ShipmentForm(null, array('edit' => true));
    }
    
    public function createAction()
    {
        if (!$this->request->isPost()) {
            return $this->forward("shipment/index");
        }

        $form = new ShipmentForm;
        $company = new Shipment();

        $data = $this->request->getPost();
        if (!$form->isValid($data, $company)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('shipment/new');
        }

        if ($company->save() == false) {
            foreach ($company->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('shipment/new');
        }

        $form->clear();

        $this->flash->success("Груз успешно создан");
        return $this->forward("shipment/index");
    }
    
    public function deleteAction($id)
    {
        $shipment = Shipment::findFirstById($id);
        
        if (!$shipment) {
            $this->flash->error("Груз не найден");
            return $this->forward("shipment/index");
        }
        
        $shipment->delete++;

        if ($shipment->save() == false) {
            foreach ($shipment->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('shipment/new');
        }

        $this->flash->success("Груз успешно удалён");
        return $this->forward("shipment/index");
    }
}
