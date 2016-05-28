<?php

use Phalcon\Flash;
use Phalcon\Session;
use Phalcon\Paginator\Adapter\NativeArray as Paginator;

class ShipmentController extends ControllerBase
{
    private $cascade = false;
    
    public function initialize()
    {
        $this->tag->setTitle('Грузы');
        parent::initialize();
    }

    public function indexAction($numberPage = 1)
    {
        $shipments = Shipment::find(array(array("del" => 0)));
        
        // Каскадное обновление
        if ($cascade) {
            foreach($shipments as $shipment) {
            if ($shipment->product->del == 1 or $shipment->transportation->del == 1) {
                $shipment->del = 1;
                $shipment->save();
                }
            }
            $cascade = false;
        }
        
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

            $shipment = Shipment::findFirst(array(array("id" => (int)$id)));
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

        $id = $this->request->getPost("id");
        $shipment = Shipment::findById($id);
        
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
        $this->view->form = new ShipmentForm(null, array('edit' => true, 'create' => true));
    }
    
    public function createAction()
    {
        if (!$this->request->isPost()) {
            return $this->forward("shipment/index");
        }

        $form = new ShipmentForm;
        $shipment = new Shipment();

        $data = $this->request->getPost();
        if (!$form->isValid($data, $shipment)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('shipment/new');
        }
        
        $count = count(Shipment::find());
        $shipment->id = $count + 1;
        $shipment->del = 0;

        if ($shipment->save() == false) {
            foreach ($shipment->getMessages() as $message) {
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
        $shipment = Shipment::findFirst(array(array("id" => (int)$id)));
        
        if (!$shipment) {
            $this->flash->error("Груз не найден");
            return $this->forward("shipment/index");
        }
        
        $shipment->del = 1;

        if ($shipment->save() == false) {
            foreach ($shipment->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('shipment/new');
        }

        $cascade = true;
        $this->flash->success("Груз успешно удалён");
        return $this->forward("shipment/index");
    }
}
