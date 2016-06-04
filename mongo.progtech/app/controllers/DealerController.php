<?php

use Phalcon\Flash;
use Phalcon\Session;
use Phalcon\Paginator\Adapter\NativeArray as Paginator;

class DealerController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Диллеры');
        parent::initialize();
    }

    public function indexAction($numberPage = 1)
    {
        $dealers = Dealer::find(array(array("del" => 0)));
        
        $paginator = new Paginator(array(
            "data"  => $dealers,
            "limit" => 10,
            "page"  => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }
    
    public function editAction($id)
    {

        if (!$this->request->isPost()) {

            $dealer = Dealer::findFirst(array(array("id" => (int)$id)));
            if (!$dealer) {
                $this->flash->error("Диллер не найден");
                return $this->forward("dealer/index");
            }

            $this->view->form = new DealerForm($dealer, array('edit' => true));
        }
    }
    
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            return $this->forward("dealer/index");
        }

        $id = $this->request->getPost("id");
        $dealer = Dealer::findById($id);
        
        if (!$dealer) {
            $this->flash->error("Автодиллер не найден");
            return $this->forward("dealer/index");
        }

        $form = new DealerForm;

        $data = $this->request->getPost();
        if (!$form->isValid($data, $dealer)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('dealer/new');
        }

        if ($dealer->save() == false) {
            foreach ($dealer->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('dealer/new');
        }

        $form->clear();

        $this->flash->success("Автодиллер успешно изменён");
        return $this->forward("dealer/index");
    }
    
    public function newAction()
    {
        $this->view->form = new DealerForm(null, array('edit' => true, 'create' => true));
    }
    
    public function createAction()
    {
        if (!$this->request->isPost()) {
            return $this->forward("dealer/index");
        }

        $form = new DealerForm;
        $dealer = new Dealer();

        $data = $this->request->getPost();
        if (!$form->isValid($data, $dealer)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('dealer/new');
        }
        
        $count = count(Dealer::find());
        $dealer->id = $count + 1;
        $dealer->del = 0;

        if ($dealer->save() == false) {
            foreach ($dealer->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('dealer/new');
        }

        $form->clear();

        $this->flash->success("Автодиллер успешно создан");
        return $this->forward("dealer/index");
    }
    
    public function deleteAction($id)
    {
        $dealer = Dealer::findFirst(array(array("id" => (int)$id)));
        
        if (!$dealer) {
            $this->flash->error("Автодиллер не найден");
            return $this->forward("dealer/index");
        }
        
        $dealer->del = 1;

        if ($dealer->save() == false) {
            foreach ($dealer->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('dealer/new');
        }

        $this->flash->success("Автодиллер успешно удалён");
        return $this->forward("dealer/index");
    }
}
